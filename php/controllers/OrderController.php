<?php

require_once "ControllerInterface.php";
require_once "../model/Orders/OrderClass.php";
require_once "../model/persist/OrderADO.php";
require_once "../model/persist/Users/UserADO.php";
require_once "../model/persist/TablesADO/TableADO.php";

class OrderControllerClass implements ControllerInterface {

    private $action;
    private $jsonData;
    private $data = [];
    private $orderADO;
    private $userADO;
    private $tableADO;

    function __construct($action, $jsonData) {
        $this->orderADO = new OrderADO();
        $this->userADO = new UserADO();
        $this->tableADO = new TableADO();
        $this->setAction($action);
        $this->setJsonData($jsonData);
    }

    public function getAction() {
        return $this->action;
    }

    public function getJsonData() {
        return $this->jsonData;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function setJsonData($jsonData) {
        $this->jsonData = $jsonData;
    }

    public function doAction() {
        switch ($this->getAction()) {
            case 1:
                $this->newClientOrder();
                break;
            case 2:
                $this->getOrdersChef();
                break;
            case 3:
                $this->setOrderPrepared();
                break;
            case 4:
                $this->getAllOrders();
                break;
            default:
                $errors = array();
                $this->data [] = false;
                $errors[] = "Sorry, there has been an error. Try later";
                $this->data[] = $errors;
                error_log("Action not correct in MealController, value: " . $this->getAction());
                break;
        }

        return $this->data;
    }

    public function getAllOrders() {
        $result = $this->orderADO->findAll()->fetchAll(PDO::FETCH_OBJ);

        if ($result != null && is_array($result)) {
            $this->data[] = true;
            $this->data[] = $result;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minuts.";
            $this->data[] = $this->errors;
        }
    }

    public function setOrderPrepared() {
        $json = json_decode(stripslashes($this->jsonData));

        $result = $this->orderADO->updateOrderStatus($json->orderId, 3)->rowCount();

        if ($result > 0) {
            $this->data[] = true;
        } else {
            $this->data[] = false;
            $this->errors[] = "There has been an error in the server while processing the orders of the chef, try again later.";
            $this->data[] = $this->errors;
        }
    }

    public function getOrdersChef() {
        $json = json_decode(stripslashes($this->jsonData));

        //1.Get the chef of the database
        $resultChef = $this->userADO->selectChefId($_SESSION['connectedUser'])->fetchAll(PDO::FETCH_OBJ);

        if (count($resultChef) > 0) {
            $chefId = $resultChef[0]->chef_id;

            $result = $this->orderADO->findChefOrders($chefId)->fetchAll(PDO::FETCH_OBJ);

            if (count($result) > 0) {
                $this->data[] = true;
                $this->data[] = $result;
            } else {
                $this->data[] = true;
                $this->data[] = [];
            }
        } else {
            $this->data[] = false;
            $this->errors[] = "There has been an error in the server while processing the orders of the chef, try again later.";
            $this->data[] = $this->errors;
        }


        //var_dump($json);
    }

    public function newClientOrder() {
        $json = json_decode(stripslashes($this->jsonData));


        //1. Check what Chef is preparing less menus
        $resultChef = $this->orderADO->findChefDisponible()->fetchAll(PDO::FETCH_OBJ);

        if (count($resultChef) == 0) {
            $chefId = 1;
        } else {
            $chefId = $resultChef[0]->chef_id;
        }

        //2. Check what waiter has less menus assigned
        $resultWaiter = $this->orderADO->findWaiterAvailable()->fetchAll(PDO::FETCH_OBJ);

        if (count($resultWaiter) == 0) {
            $waiterId = 1;
        } else {
            $waiterId = $resultWaiter[0]->waiter_id;
        }

        //3. Select the client in the table clients
        $resultClientId = $this->userADO->selectClientId($json->client->userId)->fetchAll(PDO::FETCH_OBJ);

        $clientId = $resultClientId[0]->client_id;

        if ($clientId == null) {
            $this->data[] = false;
            $this->errors[] = "There has been an error in the server while processing your order, try again later.";
            $this->data[] = $this->errors;
        } else {
            $order = new OrderClass(0, 1, $json->table->tableId, $chefId, $waiterId, $clientId, $json->menu->menuId, "", $json->totalPrice);

            $result = $this->orderADO->create($order);

            if ($result > 0) {
                $resultUpdate = $this->tableADO->updateStatus($json->table->tableId, 1)->rowCount();
                if ($resultUpdate > 0) {
                    $order->setOrderId($result);
                    $this->data[] = true;
                    $this->data[] = $order->getAll();
                } else {
                    $this->data[] = false;
                    $this->errors[] = "There has been an error in the server while processing your order, try again later.";
                    $this->data[] = $this->errors;
                }
            } else {
                $this->data[] = false;
                $this->errors[] = "There has been an error in the server while processing your order, try again later.";
                $this->data[] = $this->errors;
            }
        }
    }

}

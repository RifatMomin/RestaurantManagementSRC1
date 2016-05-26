<?php
require_once "ControllerInterface.php";
require_once "../model/persist/OrdersADO/OrderADO.php";
require_once "../model/persist/OrdersADO/OrderStatusADO.php";
require_once "../model/Menus/CourseClass.php";

class OrderController implements ControllerInterface {

    private $helperOrderAdo;
    private $helperOrderStatusAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->helperOrderAdo = new OrderADO();
        $this->helperOrderStatusAdo = new OrderStatusADO();
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
                $this->getAllOrders();
                break;
            default:
                $errors = array();
                $this->data [] = false;
                $errors[] = "Sorry, there has been an error. Try later";
                $this->data[] = $errors;
                error_log("Action not correct in User Controller, value: " . $this->getAction());
                break;
        }

        return $this->data;
    }

    
    public function getAllOrders() {
        $result = $this->helperOrderAdo->findAll()->fetchAll(PDO::FETCH_OBJ);

        if ($result != null && is_array($result)) {
            $this->data[] = true;
            $this->data[] = $result;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minuts.";
            $this->data[] = $this->errors;
        }
    }
    
    

}

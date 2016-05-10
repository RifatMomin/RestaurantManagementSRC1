<?php

/**
 * toDoClass class
 * it controls the hole server part of the application
 * @author Rifat Momin
 */
//session_start();
require_once "ControllerInterface.php";
require_once "../model/Menus/MenuItemClass.php";
require_once "../model/Menus/MenuClass.php";
require_once "../model/persist/MenusADO/MenuADO.php";
require_once "../model/persist/MenusADO/MenuItemADO.php";

class MenuControllerClass implements ControllerInterface {

    private $action;
    private $jsonData;
    private $data = [];
    private $menuADO;
    private $menuItemADO;

    function __construct($action, $jsonData) {
        $this->menuADO = new MenuADO();
        $this->menuItemADO = new MenuItemADO();
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
            //Menu methods
            case 10000:
                $this->insertMenu();
                break;
            case 10025:
                $this->getMenu();
                break;
            case 10035:
                $this->updateMenu();
                break;
            case 10066:
                $this->deleteMenu();
                break;
            //Menu Item methods
            case 11000:
                $this->insertMenuItem();
                break;
            case 11100:
                $this->getMenuItem();
                break;
            case 11200:
                $this->updateMenuItem();
                break;
            case 11300:
                $this->deleteMenuItem();
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

    public function updateMenu() {
        $menuDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $meal = new MenuClass();
        
        $meal->setAll($menuDecoded->menuId, $menuDecoded->first, $menuDecoded->second, $menuDecoded->dessert, $menuDecoded->drink, $menuDecoded->image, $menuDecoded->price);
        $result = MealADO::update($meal);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
            $this->data [] = "Menu Updated";
        } else if ($result->rowCount() == 0) {
            $errors = [0, "Nothing Updated."];
            $this->data[] = false;
            $this->data[] = $errors;
        } else {
            $errors = [1, "Server Error, try again later."];
            $this->data[] = false;
            $this->data[] = $errors;
        }
    }

    public function insertMenu() {
        $menuDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $menu = new MenuClass();
        $menu->setAll("", $menuDecoded->first, $menuDecoded->second, $menuDecoded->dessert, $menuDecoded->drink, $menuDecoded->image, $menuDecoded->price);

        $result = MenuADO::create($menu);

        if ($result > 0) {
            $this->data [] = true;
            $this->data [] = $result;
        } else {
            $this->data [] = false;
        }
    }

    public function getMenu() {
        $arrayMenus = [];
        
        $result = MenuADO::delete($menu);

        if (count($result) > 0) {
            $this->data [] = true;
            
            foreach ($result as $menu) {
                $menuObj = new MenuClass($menu['menu_id'],$menu['first'],$menu['second'],$menu['dessert'],$menu['drink'], $menu['image'], $menu['price']);
                $arrayMenus [] = $menuObj->getAll();                
            }

            $this->data[] = $arrayMenus;
        } else {
            $this->data[] = false;
        }
    }

    public function deleteMeal() {
        $jsonDecoded = json_decode($this->jsonData);

        $idMenu = $jsonDecoded;
        //Construct the review
        $menu = new MenuClass();
        $menu->setId($menuId);

        $result = MenuADO::delete($menu);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
        } else {
            $this->data[] = false;
        }
    }
    
    public function insertMenuItem(){
        $menuItemDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $menuItem = new MenuItemClass();
        $menuItem->setAll("", $menuItemDecoded->courseId, $menuItemDecoded->name, $menuItemDecoded->image, $menuItemDecoded->price);

        $result = MenuItemADO::create($menuItem);

        if ($result > 0) {
            $this->data [] = true;
            $this->data [] = $result;
        } else {
            $this->data [] = false;
        }
    }
    
    public function getMenuItem(){
        $result = $this->helperAdo->findAll();    
        $this->data[]=true;
        $this->data[]=$result->fetchAll();
    }

    public function updateMenuItem(){
        $menuItemDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $menuItem = new MenuItemClass();
        
        $menuItem->setAll("", $menuItemDecoded->courseId, $menuItemDecoded->name, $menuItemDecoded->image, $menuItemDecoded->price);
        $result = MealADO::update($menuItem);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
            $this->data [] = "Menu Item Updated";
        } else if ($result->rowCount() == 0) {
            $errors = [0, "Nothing Updated."];
            $this->data[] = false;
            $this->data[] = $errors;
        } else {
            $errors = [1, "Server Error, try again later."];
            $this->data[] = false;
            $this->data[] = $errors;
        }
    }
    public function deleteMenuItem(){
        $jsonDecoded = json_decode($this->jsonData);

        $idMenuItem = $jsonDecoded;
        //Construct the review
        $menuItem = new MenuClass();
        $menuItem->setId($idMenuItem);

        $result = MenuItemADO::delete($menuItem);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
        } else {
            $this->data[] = false;
        }
    }

}

<?php

/**
 * MenuControllerClass
 * it controls the hole server part of the application
 * @author Rifat Momin
 */
//session_start();
require_once "ControllerInterface.php";
require_once "../model/Menus/MenuItemClass.php";
require_once "../model/Menus/MenuClass.php";
require_once "../model/persist/MenusADO/MenuADO.php";
require_once "../model/persist/MenusADO/MenuItemADO.php";
require_once "../model/persist/MenusADO/CourseADO.php";

class MenuControllerClass implements ControllerInterface {

    private $action;
    private $jsonData;
    private $data = [];
    private $menuADO;
    private $menuItemADO;
    private $courseADO;

    function __construct($action, $jsonData) {
        $this->menuADO = new MenuADO();
        $this->menuItemADO = new MenuItemADO();
        $this->courseADO = new CourseADO();
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
            case 10010:
                $this->insertItemsMenu();
                break;
            case 10015:
                $this->changeActiveMenu();
                break;
            case 10025:
                $this->getMenus();
                break;
            case 10055:
                $this->getMenusClients();
                break;
            case 10035:
                $this->updateMenu();
                break;
            case 10066:
                $this->deleteMenu();
                break;
            case 10070:
                $this->deleteItemsFromMenu();
                break;
            case 10080:
                $this->insertItemsMenu();
                break;
            //Menu Item methods
            case 11000:
                $this->insertMenuItem();
                break;
            case 11100:
                $this->getMenusItem();
                break;
            case 11200:
                $this->updateMenuItem();
                break;
            case 11300:
                $this->deleteMenuItem();
                break;
            case 11400:
                $this->checkMenuItemInMenu();
                break;
            case 11500:
                $this->deleteIngredientsFromMenuItem();
                break;
            //Courses CRUD methods
            case 12000:
                $this->insertCourse();
                break;
            case 12100:
                $this->getCourses();
                break;
            case 12200:
                $this->updateCourse();
                break;
            case 12300:
                $this->deleteCourse();
                break;
            //Table Location CRUD
            case 13000:
                $this->insertTableLocation();
                break;
            case 13100:
                $this->getTableLocation();
                break;
            case 13200:
                $this->updateTableLocation();
                break;
            case 13300:
                $this->deleteTableLocation();
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
    
    public function deleteItemsFromMenu(){
        $jsonData = json_decode($this->jsonData);
        
        $result = $this->menuADO->deleteItemsFromMenu($jsonData->menuId);
        
        $error = $result->errorInfo();
        
        if($error[1]==null){
            $this->data[]=true;
            $this->data[]=$result->rowCount();
        }else{
            $this->data[] = false;
            $this->errors[] = "Can't delete the items of the menu at this moment, try again later.";
            $this->data[] = $this->errors;
        }
    }

    public function changeActiveMenu() {
        $jsonData = json_decode($this->jsonData);

        $result = $this->menuADO->updateActive($jsonData->active, $jsonData->menuId)->rowCount();

        if ($result > 0) {
            $this->data[] = true;
        } else {
            $this->data [] = false;
            $this->errors [] = "There has been an error in the server, try again later. Sorry.";
            $this->data [] = $this->errors;
        }
    }

    public function insertItemsMenu() {
        $jsonData = json_decode($this->jsonData);

        $menuItems = $jsonData->items;

        if (is_array($menuItems)) {
            if (count($menuItems) > 0) {
                $insertedItems = 0;
                foreach ($menuItems as $item) {
                    $newItem = new MenuItemClass($item->itemId, $item->course->id, $item->name, $item->image, $item->price);
                    $result = $this->menuADO->insertItemsMenu($newItem, $jsonData->menuId)->rowCount();
                    if ($result > 0) {
                        $insertedItems++;
                    }
                }

                if ($insertedItems == count($menuItems)) {
                    $this->data [] = true;
                    $this->data[] = $insertedItems;
                } else {
                    $this->data [] = false;
                    $this->errors [] = "There has been an error in the server, try again later. Sorry.";
                    $this->data [] = $this->errors;
                }
            } else {
                $this->data [] = false;
                $this->errors [] = "There has been an error in the server, try again later. Sorry.";
                $this->data [] = $this->errors;
            }
        } else {
            $this->data [] = false;
            $this->errors [] = "There has been an error in the server, try again later. Sorry.";
            $this->data [] = $this->errors;
        }
    }
   

    public function deleteIngredientsFromMenuItem() {
        $jsonData = json_decode($this->jsonData);

        $menuItemId = $jsonData->menuItemId;

        $result = $this->menuItemADO->deleteIngredientsMenuItem($menuItemId);

        if (($result->rowCount()) > 0) {
            $this->data[] = true;
            $this->data[] = $result->rowCount();
        } else {
            $this->data[] = false;
            $this->errors[] = "Can't delete the ingredient at this moment, try again later.";
            $this->data[] = $this->errors;
        }
    }

    public function checkMenuItemInMenu() {
        $menuDecoded = json_decode($this->jsonData);

        $menuItemId = $menuDecoded->menuItemId;

        $result = $this->menuItemADO->findItemInMenu($menuItemId)->rowCount();

        if ($result <= 0) {
            $this->data[] = false;
        } else {
            $this->data[] = true;
            $this->errors [] = "This Menu Item is already in a Menu. If you want to delete a Menu Item, be sure to delete the menu first.";
            $this->data[] = $this->errors;
        }
    }

    public function updateMenu() {
        $menuDecoded = json_decode($this->jsonData);


        //Create the object review to pass it to the ADO
        $menu = new MenuClass($menuDecoded->menuId, $menuDecoded->items, $menuDecoded->active, $menuDecoded->personalized, $menuDecoded->description, $menuDecoded->image, $menuDecoded->price);

        $result = $this->menuADO->update($menu)->rowCount();

        if ($result > 0) {
            $this->data[] = true;
            $this->data[] = $menu;
        } else if ($result == 0) {
            $this->data[] = true;
            $this->data[] = false;
        } else {
            $this->data [] = false;
            $this->errors [] = "Can't modify menu at this moment, try again later.";
            $this->data[] = $this->errors;
        }
    }

    public function insertMenu() {
        $menuDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $menu = new MenuClass(null, $menuDecoded->items, $menuDecoded->active, $menuDecoded->personalized, $menuDecoded->description, $menuDecoded->image, $menuDecoded->price);

        $result = $this->menuADO->create($menu);

        if ($result > 0) {
            $menu->setMenuId($result);
            $this->data [] = true;
            $this->data [] = $menu->getAll();
        } else {
            $this->data [] = false;
            $this->errors [] = "Can't add the menu at this moment, try again later.";
            $this->data[] = $this->errors;
        }
    }

    public function getMenus() {
        try {
            //ALTERNATIVE SELECT TO DO THIS
            /*
              SELECT m.menu_id, m.description, m.image, GROUP_CONCAT(mi.name SEPARATOR ';'), GROUP_CONCAT(c.course_name SEPARATOR ';')
              FROM menu m, menu_has_item mhi, menu_item mi, course c
              WHERE m.menu_id = mhi.menu_id
              AND mhi.item_id = mi.item_id
              AND mi.course_id = c.course_id
              GROUP BY m.menu_id
              ORDER BY m.menu_id
             */
            //Select all the menus
            $menus = $this->menuADO->findAll()->fetchAll(PDO::FETCH_OBJ);
            $this->data[] = true;
            $arrayAllMenus = [];
            foreach ($menus as $menu) {
                $menuArray = [];
                //Put the menu properties
                $menuArray['menu_id'] = $menu->menu_id;
                $menuArray['description'] = $menu->description;
                $menuArray['image'] = $menu->image;
                $menuArray['price'] = $menu->price;
                $menuArray['active'] = $menu->active;

                //Select all the items from the menus (table menu has item)
                $itemsMenu = $this->menuItemADO->findMenuHasItem($menu->menu_id)->fetchAll(PDO::FETCH_OBJ);
                $itemInfo = [];
                foreach ($itemsMenu as $item) {
                    //Select the properties of the item               
                    $itemsProperties = $this->menuItemADO->findItemsProps($item->item_id)->fetchAll(PDO::FETCH_OBJ);
                    foreach ($itemsProperties as $props) {
                        $newItem = [];
                        $newItem['item_id'] = $props->item_id;
                        $newItem['item_name'] = $props->name;
                        $newItem['item_image'] = $props->image;
                        $newItem['item_price'] = $props->price;
                        $newItem['course_name'] = $props->course_name;
                        $newItem['course_id'] = $props->course_id;
                        $newItem['priority'] = $props->priority;
                        $itemInfo [] = $newItem;
                    }
                    $menuArray['items'] = $itemInfo;
                }

                $arrayAllMenus [] = $menuArray;
            }

            $this->data[] = $arrayAllMenus;
        } catch (Exception $e) {
            error_log("ERROR: " + $e);
            $this->data[0] = false;
            $this->data[1] = "An error occurred in the database, try again later.";
        }
    }

    public function getMenusClients() {
        try {
            //Select all the menus
            $menus = $this->menuADO->findAllMenusClients()->fetchAll(PDO::FETCH_OBJ);
            $this->data[] = true;
            $arrayAllMenus = [];
            foreach ($menus as $menu) {
                $menuArray = [];
                //Put the menu properties
                $menuArray['menu_id'] = $menu->menu_id;
                $menuArray['description'] = $menu->description;
                $menuArray['image'] = $menu->image;
                $menuArray['price'] = $menu->price;
                $menuArray['active'] = $menu->active;

                //Select all the items from the menus (table menu has item)
                $itemsMenu = $this->menuItemADO->findMenuHasItem($menu->menu_id)->fetchAll(PDO::FETCH_OBJ);
                $itemInfo = [];
                foreach ($itemsMenu as $item) {
                    //Select the properties of the item               
                    $itemsProperties = $this->menuItemADO->findItemsProps($item->item_id)->fetchAll(PDO::FETCH_OBJ);
                    foreach ($itemsProperties as $props) {
                        $newItem = [];
                        $newItem['item_id'] = $props->item_id;
                        $newItem['item_name'] = $props->name;
                        $newItem['course_name'] = $props->course_name;
                        $newItem['priority'] = $props->priority;
                        $itemInfo [] = $newItem;
                    }
                    $menuArray['items'] = $itemInfo;
                }

                $arrayAllMenus [] = $menuArray;
            }

            $this->data[] = $arrayAllMenus;
        } catch (Exception $e) {
            error_log("ERROR: " + $e);
            $this->data[0] = false;
            $this->data[1] = "An error occurred in the database, try again later.";
        }
    }

    public function insertMenuItem() {
        $menuItemDecoded = json_decode($this->jsonData);

        //First insert he menu Item in the table menu_item
        $menuItem = new MenuItemClass(null, $menuItemDecoded->course->id, $menuItemDecoded->name, $menuItemDecoded->image, $menuItemDecoded->price);


        $result = $this->menuItemADO->create($menuItem);

        if ($result != null) {
            $this->data[] = true;
            $this->data['menuItemId'] = $result;
        } else {
            $this->data [] = false;
            $this->errors [] = "Can't insert the menu Item now, try again later. Sorry.";
            $this->data [] = $this->errors;
        }
    }

    public function getMenusItem() {
        $result = $this->menuItemADO->findAllWithIngredients()->fetchAll(PDO::FETCH_OBJ);

        if (count($result) > 0) {
            $this->data [] = true;

            $this->data[] = $result;
        } else {
            $this->data[] = false;
            $this->errors [] = "Can't get the menu items from the database";
            $this->data[] = $this->errors;
        }
    }

    public function updateMenuItem() {
        $menuItemDecoded = json_decode($this->jsonData);

        $menuItemUpdate = new MenuItemClass($menuItemDecoded->itemId, $menuItemDecoded->course->id, $menuItemDecoded->name, $menuItemDecoded->image, $menuItemDecoded->price);

        $result = $this->menuItemADO->update($menuItemUpdate);

        //Count the result 
        if ($result->rowCount() > 0) {
            $this->data [] = true;
        } else if ($result->rowCount() == 0) {
            $this->data[] = true;
            $this->errors [] = "Nothing Updated";
            $this->data[] = $this->errors;
        } else {
            $this->data[] = false;
            $this->errors [] = "Server Error, try again later.";
            $this->data[] = $this->errors;
        }
    }

    public function deleteMenuItem() {
        $jsonDecoded = json_decode($this->jsonData);

        $menuItemId = $jsonDecoded->menuItemId;

        $menuItem = new MenuItemClass($menuItemId, "", "", "", "");

        try {
            $result = $this->menuItemADO->delete($menuItem)->rowCount();


            if ($result > 0) {
                $this->data [] = true;
                $this->data[] = "Menu Item deleted correctly.";
            } else {
                $this->data[] = false;
                $this->errors[] = "Can't delete the ingredient at this moment. Try again later.";
                $this->data [] = $this->errors;
            }
        } catch (ForeignKeyException $e) {
            error_log($e);
            $this->data[] = false;
            $this->errors[] = "Can't delete the menu item because another item contains it.";
            $this->data [] = $this->errors;
        }
    }

    public function insertCourse() {
        $courseDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $course = new MenuItemClass();
        $course->setAll("", $courseDecoded->name, $courseDecoded->priority);

        $result = CourseADO::create($course);

        if ($result > 0) {
            $this->data [] = true;
            $this->data [] = $result;
        } else {
            $this->data [] = false;
        }
    }

    public function getCourses() {
        $arrayCourses = [];

        $result = $this->courseADO->findAll();

        if (count($result) > 0) {
            $this->data [] = true;

            foreach ($result as $course) {
                $courseObj = new CourseClass($course[0], $course[1], $course[2], $course[3], $course[4]);
                $arrayCourses [] = $courseObj->getAll();
            }

            $this->data[] = $arrayCourses;
        } else {
            $this->data[] = false;
        }
    }

    public function deleteCourse() {
        $jsonDecoded = json_decode($this->jsonData);

        $courseId = $jsonDecoded;
        //Construct the review
        $course = new MenuClass();
        $course->setId($courseId);

        $result = MenuItemADO::delete($course);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
        } else {
            $this->data[] = false;
        }
    }

    public function updateCourse() {
        $courseDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $course = new MenuItemClass();

        $course->setAll("", $courseDecoded->courseId, $courseDecoded->priority);
        $result = CourseADO::update($course);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
            $this->data [] = "Course updated";
        } else if ($result->rowCount() == 0) {
            $errors = [0, "Course could not be updated."];
            $this->data[] = false;
            $this->data[] = $errors;
        } else {
            $errors = [1, "Server Error, try again later."];
            $this->data[] = false;
            $this->data[] = $errors;
        }
    }

}

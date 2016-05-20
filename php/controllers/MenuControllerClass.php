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
            case 10025:
                $this->getMenus();
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
            case 11600:
                $this->modifyIngredientsMenuItem();
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

    public function modifyIngredientsMenuItem() {
        $jsonData = json_decode($this->jsonData);

        $ingredientsToDelete = $jsonData->ingredients;

        if (is_array($ingredientsToDelete)) {
            if (count($ingredientsToDelete) > 0) {
                foreach ($ingredientsToDelete as $ingredient) {
                    $newIngredient = new IngredientClass($ingredient->ingredientId,$ingredient->name,$ingredient->price);
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


//
//        //First insert he menu Item in the table menu_item
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

    public function bubbleSort($A, $n) {
        for ($i = 1; $i < $n; $i++) {
            for ($j = 0; $j < $n - $i; $j++) {
                if ($A[$j] > $A[$j + 1]) {
                    $k = $A[$j + 1];
                    $A[$j + 1] = $A[$j];
                    $A[$j] = $k;
                }
            }
        }

        return $A;
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

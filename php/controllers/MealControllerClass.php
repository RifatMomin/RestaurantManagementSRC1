<?php

/**
 * toDoClass class
 * it controls the hole server part of the application
 */
//session_start();
require_once "ControllerInterface.php";
require_once "../model/Menus/MealClass.php";
require_once "../model/persist/MenusADO/MealADO.php";

class MenuControllerClass implements ControllerInterface {

    private $action;
    private $jsonData;
    private $data = [];
    private $menuADO;

    function __construct($action, $jsonData) {
        $this->menuADO = new MealADO();
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
            case 10000://Insert Review
                $this->insertMeal();
                break;
            case 10025:
                $this->getMeals();
                break;
            case 10035:
                $this->updateMeal();
                break;
            case 10066:
                $this->deleteMeal();
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

    public function updateMeal() {
        $mealDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $meal = new MealClass();
        $meal->setAll($mealDecoded->mealId, $mealDecoded->course, $mealDecoded->name, $mealDecoded->price);
        $result = MealADO::update($meal);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
            $this->data [] = "Meal Updated";
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

    public function insertMeal() {
        $mealDecoded = json_decode($this->jsonData);

        //Create the object review to pass it to the ADO
        $meal = new MealClass();
        $meal->setAll("", $mealDecoded->idMeal, $mealDecoded->course, $mealDecoded->name, $mealDecoded->price);

        $result = MealADO::create($meal);

        if ($result > 0) {
            $this->data [] = true;
            $this->data [] = $result;
        } else {
            $this->data [] = false;
        }
    }

    public function getMeals() {
        $arrayMeals = [];
        
        $result = $this->menuADO->findAll();
        
        

        if (count($result) > 0) {
            $this->data [] = true;
            
            foreach ($result as $meal) {
                $mealObj = new MealClass($meal['meal_id'],$meal['course_id'],$meal['meal_name'],$meal['meal_price'],$meal['meal_image']);
                $arrayMeals [] = $mealObj->getAll();                
            }

            $this->data[] = $arrayMeals;
        } else {
            $this->data[] = false;
        }
    }

    public function deleteMeal() {
        $jsonDecoded = json_decode($this->jsonData);

        $idMeal = $jsonDecoded;
        //Construct the review
        $meal = new MealClass();
        $meal->setId($mealId);


        $result = MealADO::delete($meal);

        if ($result->rowCount() > 0) {
            $this->data [] = true;
        } else {
            $this->data[] = false;
        }
    }

}

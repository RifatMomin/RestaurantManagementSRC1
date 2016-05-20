<?php

require_once "ControllerInterface.php";
require_once "../model/persist/MenusADO/IngredientADO.php";
require_once "../model/Menus/IngredientClass.php";
require_once "../exceptions/ForeginKeyException.php";

class IngredientsController implements ControllerInterface {

    private $helperAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->helperAdo = new IngredientADO();
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
                $this->getAllIngredients();
                break;
            case 2:
                $this->insertIngredient();
                break;
            case 3:
                $this->removeIngredient();
                break;
            case 4:
                $this->modifyIngredient();
                break;
            case 5:
                $this->insertIngredientsMenuItem();
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

    public function insertIngredientsMenuItem() {
        $ingredientsJson = json_decode($this->jsonData);
        
        $idMenuItem = $ingredientsJson->itemId;
        $ingredientsArray = $ingredientsJson->ingredients;

        if (is_array($ingredientsArray)) {
            if (count($ingredientsArray) > 0) {
                $numberIngredientsInserted = 0;
                $this->data[] = true;
                foreach ($ingredientsArray as $ing) {
                    $newIng = new IngredientClass($ing->ingredientId, $ing->name, $ing->price);
                    $resultInsert = $this->helperAdo->createMenuItemIngredient($newIng, $idMenuItem)->rowCount();
                    if ($resultInsert > 0) {
                        $numberIngredientsInserted++;
                        $this->data[1] = $numberIngredientsInserted;
                    } else {
                        $this->data[0] = false;
                        $this->errors[] = "There has been an error inserting the menu item ingredients, try later. Sorry";
                        $this->data[1] = $this->errors;
                        break;
                    }
                }
            }
        } else {
            $this->data[] = false;
            $this->errors[] = "There has been an error inserting the menu item ingredients, try later. Sorry";
            $this->data[] = $this->errors;
        }
    }

    public function modifyIngredient() {
        $json = json_decode($this->jsonData);
                
        $ingredient = new IngredientClass($json->ingredientId, $json->name, $json->price);

        $result = $this->helperAdo->update($ingredient);

        if ($result->rowCount() > 0) {
            $this->data[] = true;
            $this->data[] = $ingredient->getAll();
            $this->data[] = "Ingredient Modifyied";
        } else if ($result->rowCount() == 0) {
            $this->data[] = true;
            $this->data[] = "Nothing Modifyied.";
        } else {
            $this->data[] = false;
            $this->errors[] = "Can't update the ingredient at this moment. Try again later.";
            $this->data[] = $this->errors;
        }
    }

    public function removeIngredient() {
        $json = json_decode($this->jsonData);

        try {
            $result = $this->helperAdo->delete($json->id);


            if ($result->rowCount() > 0) {
                $this->data[] = true;
            } else {
                $this->data[] = false;
                $this->errors[] = "Can't delete the ingredient at this moment. Try again later.";
                $this->data [] = $this->errors;
            }
        } catch (ForeignKeyException $e) {
            $this->data[] = false;
            $this->errors[] = "Can't delete the ingredient because another item contains it.";
            $this->data [] = $this->errors;
        }
    }

    public function insertIngredient() {
        $json = json_decode($this->jsonData);

        $ingredient = new IngredientClass("", $json->name, $json->price);

        $result = $this->helperAdo->create($ingredient);

        if ($result != null) {
            $ingredient->setId($result);
            $this->data[] = true;
            $this->data[] = $ingredient->getAll();
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minuts.";
            $this->data[] = $this->errors;
        }
    }

    public function getAllIngredients() {
        $result = $this->helperAdo->findAll()->fetchAll(PDO::FETCH_OBJ);

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

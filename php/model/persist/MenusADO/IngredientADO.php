<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Menus/IngredientClass.php";

class IngredientADO implements EntityInterfaceADO {
    //Queries
    const SELECT_ALL_INGREDIENTS = "SELECT * FROM ingredient ORDER BY ingredient_name";
    const INSERT_INGREDIENT = "INSERT INTO `ingredient` (`ingredient_name`, `price`) VALUES (?, ?)";
    const DELETE_INGREDIENT = "DELETE FROM `ingredient` WHERE `ingredient_id` = ?";
    const UPDATE_INGREDIENT = "UPDATE `ingredient` SET `ingredient_name` = ?, `price` = ? WHERE `ingredient_id` = ?";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($ingredient) {
        $array=[$ingredient->getName(),$ingredient->getPrice()];
        
        return $this->dataSource->executionInsert(self::INSERT_INGREDIENT, $array);
    }

    public function delete($ingredientId) {
        return $this->dataSource->execution(self::DELETE_INGREDIENT, $array=[$ingredientId]);
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_INGREDIENTS,$array=[]);
    }

    public function update($ingredient) {
        $array = [
                $ingredient->getName(),
                $ingredient->getPrice(),
                $ingredient->getId()
                ];
        
        return $this->dataSource->execution(self::UPDATE_INGREDIENT,$array);
    }

}

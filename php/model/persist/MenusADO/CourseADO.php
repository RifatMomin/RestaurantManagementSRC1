<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Menus/CourseClass.php";

class CourseADO implements EntityInterfaceADO {
    //Queries
    const SELECT_ALL = "SELECT * FROM course ORDER BY priority";
    
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
        return $this->dataSource->execution(self::SELECT_ALL,$array=[]);
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

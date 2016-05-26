<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/Users/ChefClass.php";

class ChefADO{
    //Queries
    const SELECT_ALL_CHEFS= "SELECT * FROM chef";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_CHEFS,$array=[]);
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

}


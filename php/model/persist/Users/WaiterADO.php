<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/Users/WaiterClass.php";

class WaiterADO{
    //Queries
    const SELECT_ALL_WAITERS= "SELECT * FROM waiter";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_WAITERS,$array=[]);
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

}


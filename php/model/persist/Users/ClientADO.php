<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/Users/ClientClass.php";

class ClientADO{
    //Queries
    const SELECT_ALL_CLIENTS= "SELECT * FROM client";
    const SELECT_CLIENT_ID = "";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_CLIENTS,$array=[]);
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

}


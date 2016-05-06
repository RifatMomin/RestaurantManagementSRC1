<?php

require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/RestaurantClass.php";

class RestaurantInfoADO implements EntityInterfaceADO {

    //Constants of the QUERIES
    const SELECT_INFO = "SELECT * FROM restaurant";
   
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_INFO,$array=[]);
    }

    public function update($entity) {
        
    }

}

?>

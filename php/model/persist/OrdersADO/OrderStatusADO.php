<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Orders/OrderStatusClass.php";

class OrderStatusADO implements EntityInterfaceADO {
    //Queries
    const SELECT_ALL_ORDER_STATUS= "SELECT * FROM status_order";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_ORDER_STATUS,$array=[]);
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

}


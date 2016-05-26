<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Orders/OrderClass.php";

class OrderADO implements EntityInterfaceADO {
    //Queries
    const SELECT_ALL_ORDERS= "SELECT ord.*, stat.*, tab.*, ch.*, wa.*, cl.*, m.* FROM orders ord, status_order stat, tables_restaurant tab, chef ch, waiter wa, client cl, menu m WHERE ord.status_id = stat.status_id AND ord.table_id = tab.table_id AND ord.chef_id = ch.chef_id AND ord.waiter_id = wa.waiter_id AND ord.client_id = cl.client_id AND ord.menu_id = m.menu_id ORDER by order_date";

    private $dataSource;
    
    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_ORDERS,$array=[]);
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

}


<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/ReviewClass.php";

class ReviewADO implements EntityInterfaceADO {
    //Queries
    const SELECT_ALL_REVIEWS = "SELECT r.*, u.user_name, u.surname FROM REVIEWS r, users u WHERE r.client_id = u.user_id ";
    
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($entity) {
        
    }

    public function delete($entity) {
        
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_REVIEWS,$array=[]);
    }

    public function update($entity) {
        
    }

}

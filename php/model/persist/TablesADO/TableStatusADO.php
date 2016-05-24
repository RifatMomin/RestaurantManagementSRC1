<?php
require_once "../model/persist/DBConnect.php";
//require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Tables/TableStatusClass.php";
//implements EntityInterfaceADO
class TableStatusADO {
    //Queries
    const SELECT_ALL_TABLE_STATUS= "SELECT * FROM table_status";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function findAll() {
        //var_dump($obj);
        return $this->dataSource->execution(self::SELECT_ALL_TABLE_STATUS,$array=[]);
        //return $obj;
        
    }



}


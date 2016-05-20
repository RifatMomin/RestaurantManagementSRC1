<?php
require_once "../model/persist/DBConnect.php";
//require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Tables/TableTypeClass.php";
//implements EntityInterfaceADO
class TableADO {
    //Queries
    const SELECT_ALL_TABLES= "SELECT tab.*, type.*, stat.*, locat.* FROM tables_restaurant tab, table_status stat, table_types type, table_locations locat WHERE tab.type_id = type.type_id AND tab.table_status = stat.table_status_id AND TAB.table_location = locat.location_id ORDER BY table_id";
    //const INSERT_TABLE = "INSERT INTO tables_restaurant(name_type) VALUES (?)";
    //const DELETE_TABLE= "DELETE FROM tables_restaurant WHERE type_id = ?";
    //const UPDATE_TABLE = "UPDATE tables_restaurant SET name_type= ? WHERE type_id = ?";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($tableType) {
        //var_dump($tableType);
        /*$array=[$tableType->getName()];
        
        return $this->dataSource->executionInsert(self::INSERT_TABLE, $array);*/
    }

    public function delete($tableTypeId) {
        //return $this->dataSource->execution(self::DELETE_TABLE, $array=[$tableTypeId->id]);
    }

    public function findAll() {

        return $this->dataSource->execution(self::SELECT_ALL_TABLES,$array=[]);
        
    }

    public function update($tableType) {
        //var_dump($course);
        /*$array = [
            $tableType->name_type,
            $tableType->type_id
        ];
        
        return $this->dataSource->execution(self::UPDATE_TABLE,$array);*/
    }


}


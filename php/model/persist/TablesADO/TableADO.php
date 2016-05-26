<?php
require_once "../model/persist/DBConnect.php";
//require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Tables/TableClass.php";
//implements EntityInterfaceADO
class TableADO {
    //Queries
    const SELECT_ALL_TABLES= "SELECT tab.*, type.*, stat.*, locat.* FROM tables_restaurant tab, table_status stat, table_types type, table_locations locat WHERE tab.type_id = type.type_id AND tab.table_status = stat.table_status_id AND TAB.table_location = locat.location_id ORDER BY table_id";
    const INSERT_TABLE = "INSERT INTO tables_restaurant(type_id, table_status, table_location, capacity, active) VALUES (?, ?, ?, ?, ?)";
    const DELETE_TABLE= "DELETE FROM tables_restaurant WHERE table_id = ?";
    const UPDATE_TABLE = "UPDATE tables_restaurant SET type_id= ?, table_status = ?, table_location = ?, capacity = ?, active = ? WHERE table_id = ?";
    const UPDATE_ACTIVE_TABLE = "UPDATE tables_restaurant SET active = ? WHERE table_id = ?";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($table) {
        
        $array=[
            $table->getType_id()->type_id,
            $table->getTable_status()->table_status_id,
            $table->getTable_location()->location_id,
            $table->getCapacity(),
            $table->getActive()
           ];
           
        return $this->dataSource->executionInsert(self::INSERT_TABLE, $array);
    }

    public function delete($table) {
        
        return $this->dataSource->execution(self::DELETE_TABLE, $array=[$table->table_id]);
    }

    public function findAll() {

        return $this->dataSource->execution(self::SELECT_ALL_TABLES,$array=[]);
        
    }

    public function update($table) {
        //var_dump($course);
        $array = [
            $table->type_id,
            $table->table_status,
            $table->table_location,
            $table->capacity,
            $table->table_id
        ];
        
        return $this->dataSource->execution(self::UPDATE_TABLE,$array);
    }
    
    public function updateActiveTable ($table){
        $array = [
            $table->active, 
            $table->table_id
        ];
        //var_dump($array);
        return $this->dataSource->execution(self::UPDATE_ACTIVE_TABLE, $array);
    }

}


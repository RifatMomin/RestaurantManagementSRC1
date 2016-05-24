<?php
require_once "../model/persist/DBConnect.php";
//require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Tables/TableTypeClass.php";
//implements EntityInterfaceADO
class TableTypeADO {
    //Queries
    const SELECT_ALL_TABLE_TYPE= "SELECT * FROM table_types";
    const INSERT_TABLE_TYPE = "INSERT INTO table_types(name_type) VALUES (?)";
    const DELETE_TABLE_TYPE = "DELETE FROM table_types WHERE type_id = ?";
    const UPDATE_TABLE_TYPE = "UPDATE table_types SET name_type= ? WHERE type_id = ?";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($tableType) {
        //var_dump($tableType);
        $array=[$tableType->getName()];
        
        return $this->dataSource->executionInsert(self::INSERT_TABLE_TYPE, $array);
    }

    public function delete($tableTypeId) {
        return $this->dataSource->execution(self::DELETE_TABLE_TYPE, $array=[$tableTypeId->id]);
    }

    public function findAll() {

        return $this->dataSource->execution(self::SELECT_ALL_TABLE_TYPE,$array=[]);
        
    }

    public function update($tableType) {
        //var_dump($course);
        $array = [
            $tableType->name_type,
            $tableType->type_id
        ];
        
        return $this->dataSource->execution(self::UPDATE_TABLE_TYPE,$array);
    }


}


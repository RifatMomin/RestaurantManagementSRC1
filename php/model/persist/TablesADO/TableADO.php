<?php

require_once "../model/persist/DBConnect.php";
//require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Tables/TableClass.php";

//implements EntityInterfaceADO
class TableADO {

    //Queries
    const SELECT_ALL_TABLES = "SELECT tab.*, type.*, stat.*, locat.* FROM tables_restaurant tab, table_status stat, table_types type, table_locations locat WHERE tab.type_id = type.type_id AND tab.table_status = stat.table_status_id AND TAB.table_location = locat.location_id ORDER BY table_id";
    const INSERT_TABLE = "INSERT INTO tables_restaurant(type_id, table_status, table_location, capacity) VALUES (?, ?, ?, ?)";
    const DELETE_TABLE = "DELETE FROM tables_restaurant WHERE table_id = ?";
    const UPDATE_TABLE = "UPDATE tables_restaurant SET type_id= ?, table_status = ?, table_location = ?, capacity = ? WHERE table_id = ?";
    const UPDATE_STATUS = "UPDATE tables_restaurant SET table_status = ? WHERE table_id = ?";

    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($table) {
        //var_dump($table);
        $array = [
            $table->getType(),
            $table->getStatus(),
            $table->getLocation(),
            $table->getCapacity()
        ];

        return $this->dataSource->executionInsert(self::INSERT_TABLE, $array);
    }

    public function updateStatus($tableId, $status) {
        return $this->dataSource->execution(self::UPDATE_STATUS, $array = [$status, $tableId]);
    }

    public function delete($tableId) {
        return $this->dataSource->execution(self::DELETE_TABLE, $array = [$tableId->id]);
    }

    public function findAll() {

        return $this->dataSource->execution(self::SELECT_ALL_TABLES, $array = []);
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

        return $this->dataSource->execution(self::UPDATE_TABLE, $array);
    }

}

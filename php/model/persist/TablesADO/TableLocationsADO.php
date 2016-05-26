<?php
require_once "../model/persist/DBConnect.php";
//require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Tables/TableLocationClass.php";
//implements EntityInterfaceADO
class TableLocationsADO {
    //Queries
    const SELECT_ALL_TABLE_LOCATIONS= "SELECT * FROM table_locations";
    const INSERT_TABLE_LOCATION = "INSERT INTO table_locations(name_location) VALUES (?)";
    const DELETE_TABLE_LOCATION = "DELETE FROM table_locations WHERE location_id = ?";
    const UPDATE_TABLE_LOCATION = "UPDATE table_locations SET name_location= ? WHERE location_id = ?";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($tableLocation) {
        
        $array=[$tableLocation->getNameLocation()];
        
        return $this->dataSource->executionInsert(self::INSERT_TABLE_LOCATION, $array);
    }

    public function delete($tableLocationId) {
        return $this->dataSource->execution(self::DELETE_TABLE_LOCATION, $array=[$tableLocationId->id]);
    }

    public function findAll() {

        return $this->dataSource->execution(self::SELECT_ALL_TABLE_LOCATIONS,$array=[]);
        
    }

    public function update($tableLocation) {
        //var_dump($course);
        $array = [
            $tableLocation->name_location,
            $tableLocation->location_id
        ];
        
        return $this->dataSource->execution(self::UPDATE_TABLE_LOCATION,$array);
    }


}


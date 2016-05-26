<?php

require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/RestaurantClass.php";

class RestaurantInfoADO implements EntityInterfaceADO {

    //Constants of the QUERIES
    const SELECT_INFO = "SELECT * FROM restaurant";
    const INSERT_INFO = "INSERT INTO restaurant (CIF, name, email, phone1, phone2, address, city, zip_code, description) VALUES ('', '', '', '', NULL, '', '', '', '')";
    const UPDATE_INFO = "UPDATE restaurant SET CIF=?, name=? ,email=?, phone1=?, phone2=?, address=?, city=?, zip_code=?, description=? WHERE restaurant_id=?";
    const GET_REST_ID = "SELECT restaurant_id FROM restaurant";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($restObj) {

        $restObj = $this->findAll();
        if ($restObj == null) {
            $array = [
                $restObj->getCIF(),
                $restObj->getName(),
                $restObj->getAddress(),
                $restObj->getCity(),
                $restObj->getZipCode(),
                $restObj->getPhone1(),
                $restObj->getPhone2(),
                $restObj->getEmail(),
                $restObj->getDescription()
            ];

            return $this->dataSource->executionInsert(self::INSERT_INFO, $array);
        }
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_INFO, $array = []);
    }
    
    public function findId(){
        return $this->dataSource->execution(self::GET_REST_ID, $array = []);
    }
    
    public function update($restNewObj) {

        if($restNewObj !=null){
            $arrayNew = [
                $restNewObj->getCIF(),
                $restNewObj->getName(),
                $restNewObj->getEmail(),
                $restNewObj->getPhone1(),
                $restNewObj->getPhone2(),
                $restNewObj->getAddress(),
                $restNewObj->getCity(),
                $restNewObj->getZipCode(),
                $restNewObj->getDescription(),
                $restNewObj->getId()
            ];
            return $this->dataSource->execution(self::UPDATE_INFO, $arrayNew);
        }
        else{
            create($entity);
        }
        
    }

    //not implemented 
    public function delete($restObj) {
        
    }

}

?>

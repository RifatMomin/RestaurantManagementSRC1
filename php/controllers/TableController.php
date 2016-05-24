<?php
require_once "ControllerInterface.php";
require_once "../model/persist/TablesADO/TableLocationsADO.php";
require_once "../model/persist/TablesADO/TableTypeADO.php";
require_once "../model/persist/TablesADO/TableADO.php";
require_once "../model/Tables/TableClass.php";
require_once "../model/Tables/TableLocationClass.php";
require_once "../model/Tables/TableStatusClass.php";
require_once "../model/Tables/TableTypeClass.php";

/*
* This is the table controller
 * it controls the tables Management
 * @author Rifat Momin
*/

class TableController implements ControllerInterface {
    
    //attributes
    private $helperLocationAdo;
    private $helperTypeAdo;
    private $helperTableAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];
    
    //constructor
    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->helperLocationAdo = new TableLocationsADO();
        $this->helperTypeAdo = new TableTypeADO();
        $this->helperTableAdo = new TableADO;
    }
    
    public function getAction() {
        return $this->action;
    }

    public function getJsonData() {
        return $this->jsonData;
    }

    public function setAction($action) {
        $this->action = $action;
    }

    public function setJsonData($jsonData) {
        $this->jsonData = $jsonData;
    }

    public function doAction() {
        switch ($this->getAction()) {
            //Table Location CRUD
            case 1:
                $this->getAllTableLocations();
                break;
            case 2: 
                $this->addNewTableLocation();
                break;
            case 3:
                $this->deleteTableLocation();
                break;
            case 4:
                $this->updateTableLocation();
                break;
            //Table Type CRUD
            case 5:
                $this->getAllTableTypes();
                break;
            case 6: 
                $this->addNewTableTypes();
                break;
            case 7:
                $this->deleteTableTypes();
                break;
            case 8:
                $this->updateTableTypes();
                break;
            //Table CRUD
            case 9:
                $this->getAllTables();
                break;
            case 10: 
                $this->addNewTable();
                break;
            case 11:
                $this->deleteTable();
                break;
            case 12:
                $this->updateTable();
                break;
            default:
                $errors = array();
                $this->data [] = false;
                $errors[] = "Sorry, there has been an error. Try later";
                $this->data[] = $errors;
                error_log("Action not correct in User Controller, value: " . $this->getAction());
                break;
        }

        return $this->data;
    }
    
    /*
    * @name getAllTableLocations
    * @description gets all table locations from db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function getAllTableLocations() {
        $result = $this->helperLocationAdo->findAll()->fetchAll(PDO::FETCH_OBJ);
        //var_dump($result);
        if ($result != null && is_array($result)) {
            $this->data[] = true;
            $this->data[] = $result;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minutes.";
            $this->data[] = $this->errors;
        }
    }
    
    /*
    * @name addNewTableLocation
    * @description adds a new table location to db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function addNewTableLocation(){
        $tableLocation = json_decode(stripslashes($this->getJsonData()));
        $table= new TableLocationClass("", $tableLocation->name);
        
        $result = $this->helperLocationAdo->create($table);

        if ($result != null) {
            $this->data[] = true;
            $this->errors = [];
            $this->data [] = $this->errors;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minutes.";
            $this->data[] = $this->errors;
        }
    }
    
    /*
    * @name deleteTableLocation
    * @description deletes table location from db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function deleteTableLocation(){
        $tableDecoded = json_decode(stripslashes($this->jsonData));
        //var_dump($courseDecoded);
        $result = $this->helperLocationAdo->delete($tableDecoded);
        //var_dump($result);
        if ($result->rowCount()>0) {
            $this->data[] = true;
            $this->errors= [];
            $this->data [] = $this->errors;
        } else {
            $this->data[] = false;
            $this->errors[] = "Can't delete table location at this moment. Try later.";
            $this->data [] = $this->errors;
        }
    }
    
    /*
    * @name updateTableLocation
    * @description updates table location to db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function updateTableLocation(){
        $tableDecoded = json_decode(stripslashes($this->jsonData));
        //var_dump($tableDecoded);
        $result = $this->helperLocationAdo->update($tableDecoded);
        
        if($result->rowCount()>0){
            $this->data[] = true;
            $this->errors= [];
            $this->data [] = $this->errors;
        }
        else{
            $this->data [] = false;
            $this->errors[] = "Can't update table location right now. Try later.";
            $this->data [] = $this->errors;
        }
        
    }
    
    /*
    * @name getAllTableTypes
    * @description retrieves all table types
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function getAllTableTypes(){
        $result = $this->helperTypeAdo->findAll()->fetchAll(PDO::FETCH_OBJ);

        if ($result != null && is_array($result)) {
            $this->data[] = true;
            $this->data[] = $result;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minutes.";
            $this->data[] = $this->errors;
        }
    }
    
    /*
    * @name addNewTableTypes
    * @description adds a new table type to db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function addNewTableTypes(){
        $tableType = json_decode(stripslashes($this->getJsonData()));
        $table= new TableTypeClass("", $tableType->name);
        
        $result = $this->helperTypeAdo->create($table);

        if ($result != null) {
            $this->data[] = true;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minutes.";
            $this->data[] = $this->errors;
        }
    }
    
    /*
    * @name deleteTableTypes
    * @description deletes table type from db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function deleteTableTypes(){
        $courseDecoded = json_decode(stripslashes($this->jsonData));
        //var_dump($courseDecoded);
        $result = $this->helperTypeAdo->delete($courseDecoded);
        //var_dump($result);
        if ($result->rowCount()>0) {
            $this->data[] = true;
            $this->errors= [];
            $this->data [] = $this->errors;
        } else {
            $this->data[] = false;
            $this->errors[] = "Can't delete table type at this moment. Try later.";
            $this->data [] = $this->errors;
        }
    }
    
    /*
    * @name updateTableTypes
    * @description updates table type to db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/19
    */
    public function updateTableTypes(){
        $tableDecoded = json_decode(stripslashes($this->jsonData));
        //var_dump($tableDecoded);
        $result = $this->helperTypeAdo->update($tableDecoded);
        
        if($result->rowCount()>0){
            $this->data[] = true;
            $this->errors= [];
            $this->data [] = $this->errors;
        }
        else{
            $this->data [] = false;
            $this->errors[] = "Can't update table type right now. Try later.";
            $this->data [] = $this->errors;
        }
    }
    
    
    /*
    * @name getAllTables
    * @description retrieves all tables from db
    * @version 1
    * @author Rifat Momin
    * @date 2016/05/20
    */            
    public function getAllTables(){
        $result = $this->helperTableAdo->findAll()->fetchAll(PDO::FETCH_OBJ);

        if ($result != null && is_array($result)) {
            $this->data[] = true;
            $this->data[] = $result;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minutes.";
            $this->data[] = $this->errors;
        }
    }
    
    
    public function addNewTable(){}
    public function deleteTable(){}
    public function updateTable(){}
    

}

<?php
require_once "ControllerInterface.php";
require_once "../model/persist/RestaurantInfoADO.php";

class RestaurantInfoController implements ControllerInterface {

    private $helperAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->helperAdo = new RestaurantInfoADO();
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
            case 1:
                $this->getInfo();
                break;
            case 2:
                $this->insertInfo();
                break;
            case 3:
                $this->updateInfo();
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

    public function getInfo(){
        $result = $this->helperAdo->findAll();
        $this->data[]=true;
        $this->data[]=$result->fetchAll();
        
    }
    
    public function insertInfo(){
        $restaurant= json_decode(stripslashes($this->getJsonData()));
        $result = $this->helperAdo->create($restaurant);
        
        if($result!=null){
            $this->data [] = false;
            $this->errors [] = "Restaurant Info insert";
            $this->data [] = $this->errors;
        }
        else{
            $this->data [] = false;
            $this->errors [] = "Restaurant Info could not be inserted";
            $this->data [] = $this->errors;
        }
    }
    
    public function updateInfo(){

        $restaurant= json_decode(stripslashes($this->getJsonData()));
        $OldRestObj= new RestaurantClass("", $restaurant[0]->CIF);
        $NewRestObj= new RestaurantClass("", $restaurant[1]->CIF, $restaurant[1]->name, $restaurant[1]->address, $restaurant[1]->city, $restaurant[1]->zipCode, $restaurant[1]->phone1, $restaurant[1]->phone2, $restaurant[1]->email, $restaurant[1]->description);

        $result = $this->helperAdo->updated($NewRestObj, $OldRestObj);
        if($result!=null){
            $this->data [] = false;
            $this->errors [] = "Restaurant Info updated";
            $this->data [] = $this->errors;
        }
        else{
            $this->data [] = false;
            $this->errors [] = "Restaurant Info could not be updated";
            $this->data [] = $this->errors;
        }
       
    }

}

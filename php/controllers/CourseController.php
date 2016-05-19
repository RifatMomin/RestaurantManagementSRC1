<?php
require_once "ControllerInterface.php";
require_once "../model/persist/MenusADO/CourseADO.php";
require_once "../model/Menus/CourseClass.php";

class CourseController implements ControllerInterface {

    private $helperAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->helperAdo = new CourseADO();
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
                $this->getAllCourseTypes();
                break;
            case 2: 
                $this->addNewCourse();
                break;
            case 3:
                $this->deleteCourse();
                break;
            case 4:
                $this->updateCourse();
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

    
    public function getAllCourseTypes() {
        $result = $this->helperAdo->findAll()->fetchAll(PDO::FETCH_OBJ);

        if ($result != null && is_array($result)) {
            $this->data[] = true;
            $this->data[] = $result;
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minuts.";
            $this->data[] = $this->errors;
        }
    }
    
    public function addNewCourse(){
        $courseDecoded = json_decode(stripslashes($this->getJsonData()));
        $course= new CourseClass("", $courseDecoded->name, $courseDecoded->priority);
        
        $result = $this->helperAdo->create($course);

        if ($result != null) {
            $this->data[] = true;
            //$this->data[] = $courseDecoded->findAll();
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minutes.";
            $this->data[] = $this->errors;
        }
    }
    
    public function deleteCourse(){
        $courseDecoded = json_decode(stripslashes($this->jsonData));
        //var_dump($courseDecoded);
        $result = $this->helperAdo->delete($courseDecoded);
        //var_dump($result);
        if ($result->rowCount()>0) {
            $this->data[] = true;
        } else {
            $this->data[] = false;
            $this->errors[] = "Can't delete course at this moment. Try later.";
            $this->data [] = $this->errors;
        }
        
    }
    
    public function updateCourse(){
        $courseDecoded = json_decode(stripslashes($this->jsonData));
        //var_dump($courseDecoded);
        $result = $this->helperAdo->update($courseDecoded);
        
        if($result->rowCount()>0){
            $this->data[] = true;
            $this->errors= [];
            $this->data [] = $this->errors;
        }
        else{
            $this->data [] = false;
            $this->errors[] = "Can't update course right now. Try later.";
            $this->data [] = $this->errors;
        }
        
    }
    

}

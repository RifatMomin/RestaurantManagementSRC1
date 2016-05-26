<?php
require_once "ControllerInterface.php";
require_once "../model/persist/ReviewsADO.php";

class ReviewsController implements ControllerInterface {

    private $helperAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->helperAdo = new ReviewADO();
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
                $this->getAllReviews();
                break;
            case 2:
                $this->addReview();
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

    public function getAllReviews(){
        $result = $this->helperAdo->findAll()->fetchAll(PDO::FETCH_OBJ);
        
        if($result!=null && is_array($result)){
            $this->data[]=true;
            $this->data[] = $result;
        }else{
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minuts.";
        }
    }
    
    public function addReview(){
        $reviewDecoded = json_decode(stripslashes($this->getJsonData()));
        $review= new ReviewClass("", $reviewDecoded->name, $reviewDecoded->priority);
        var_dump($reviewDecoded);
        $result = $this->helperAdo->create($review);

        if ($result != null) {
            $this->data[] = true;
            //$this->data[] = $courseDecoded->findAll();
        } else {
            $this->data[] = false;
            $this->errors[] = "Sorry there has been an error in the server, try again later or in a few minutes.";
            $this->data[] = $this->errors;
        }
    }
    

}

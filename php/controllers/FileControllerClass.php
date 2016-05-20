<?php

require_once "ControllerInterface.php";
require_once "../model/Users/UserClass.php";
require_once "../model/persist/Users/UserADO.php";

class FileControllerClass implements ControllerInterface {

    private $helperAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->helperAdo = new UserADO();
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
        $newFileNames = array();
        $outPutData = array();

        switch ($this->getAction()) {
            case 250:
                $this->saveFile();
                break;
            case 260:
                $this->updateFile();
                break;
            default:
                echo "Action not correct: " . $_REQUEST["action"];
                break;
        }

        return $this->data;
    }

    function updateFile() {
        if (isset($_SESSION['connectedUser'])) {
            $userId = $_SESSION['connectedUser'];

            //Get the image of the user in the database
            $username = $this->helperAdo->findById($userId)->fetch(PDO::FETCH_OBJ)->username;
            
            foreach ($_FILES['images']['error'] as $key => $error) {
                //Check if there's some errors
                if ($error == UPLOAD_ERR_OK) {
                    //Get the name of the image
                    $name = $_FILES['images']['name'][$key];

                    //Explode the name into an array
                    $fileNameParts = explode(".", $name);

                    //Get the extension of the image
                    $extension = end($fileNameParts);

                    //Set the new fileName
                    $newFileName = $username . "." . $extension;
                    

                    //Move the file to the right place
                    move_uploaded_file($_FILES['images']['tmp_name'][$key],'../../images/users/' .  $newFileName);                    
                    
                    $this->data[] = true;
                    $this->data[] = $newFileName;
                } else {
                    $this->data[] = false;
                    $this->errors[] = "An error occurred while uploading the image, try again later.";
                    $this->data[] = $this->errors;
                }
            }
        }
    }

    function saveFile() {
        $imageName = str_replace(' ', '', $_REQUEST['imageName']);
        $newFileName = "";
        $i = 0;

        if ($imageName != null && isset($_FILES['images'])) {
            foreach ($_FILES['images']['error'] as $key => $error) {
                //Check if there's some errors
                if ($error == UPLOAD_ERR_OK) {
                    //Get the name of the image
                    $name = $_FILES['images']['name'][$key];

                    //Explode the name into an array
                    $fileNameParts = explode(".", $name);

                    //Get the extension of the image
                    $extension = end($fileNameParts);

                    //Set the new fileName
                    $newFileName = $imageName . "." . $extension;

                    $locationFile = '../../images/users/';
                    
                    if(isset($_REQUEST['menuItem'])){
                        $locationFile = "../../images/menu_items/";
                    }
                    
                    //Move the file to the right place
                    move_uploaded_file($_FILES['images']['tmp_name'][$key], $locationFile . $newFileName);

                    $i++;

                    $this->data[] = true;
                    $this->data[] = $newFileName;
                } else {
                    $this->data[] = false;
                    $this->errors[] = "An error occurred while uploading the image, try again later.";
                    $this->data[] = $this->errors;
                }
            }
        } else {
            $this->data[] = false;
            $this->errors[] = "An error occurred while uploading the image, try again later.";
            $this->data[] = $this->errors;
        }
    }

}

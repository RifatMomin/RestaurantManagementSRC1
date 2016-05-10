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
        $actualImage = $_REQUEST['actualImage'];
        
        $arrayActualImage = explode("/",$actualImage);        
        
        $actualImage = $arrayActualImage[2];
        $username = $_REQUEST['userName'];       
        
        
        if ($actualImage != null && $username != null) {            
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
                    $newFileName =  $username . "." . $extension;

                    echo "Actual Image: " . $actualImage;
                    echo "\nNew Image: " . $newFileName;

                    if (strcmp($newFileName, $actualImage) != 0) {
                        
                    } else {
                        
                    }
                    //Move the file to the right place
                    //move_uploaded_file($_FILES['images']['tmp_name'][$key],'../../images/users/' .  $newFileName);
//                $i++;
//
//                $this->data[] = true;
//                $this->data[] = $newFileName;
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

    function saveFile() {
        $username = $_REQUEST['userName'];
        $newFileName = "";
        $i = 0;

        if ($username != null && isset($_FILES['images'])) {
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
                    move_uploaded_file($_FILES['images']['tmp_name'][$key], '../../images/users/' . $newFileName);

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

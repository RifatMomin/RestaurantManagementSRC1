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
            case "250":
                $this->saveFile();
                break;
            case "10010":
                //This option is to upload users images to the server
                //$_FILES contains all the file to upload
                //The program returns an array with the new file's name that ust be inserted into the database
                foreach ($_FILES['images']['error'] as $key => $error) {
                    if ($error == UPLOAD_ERR_OK) {
                        $name = $_FILES['images']['name'][$key];
                        $fileNameParts = explode(".", $name);
                        $nameWithoutExtension = $fileNameParts[0];
                        $extension = end($fileNameParts);
                        $newFileName = $this->getJsonData() . "." . $extension;
                        move_uploaded_file($_FILES['images']['tmp_name'][$key], '../../images/usersImages/' . $newFileName);

                        $newFileNames[] = 'images/usersImages/' . $newFileName;
                    }
                }
                $outPutData[] = true;
                $outPutData[] = $newFileNames;
                $fileView = new FileViewClass($outPutData);
                break;
            case "10020":
                //This option is to remove files from the server
                //$_REQUEST["JSONData"] contains all the file's names to remove
                $filesToDeleteArray = json_decode(stripslashes($this->getJsonData()));

                foreach ($filesToDeleteArray as $filename) {
                    if (file_exists('../../' . $filename))
                        unlink('../../' . $filename);
                }

                $outPutData[] = true;
                $fileView = new FileViewClass($outPutData);
                break;
            default:
                echo "Action not correct: " . $_REQUEST["action"];
                break;
        }

        return $this->data;
    }

    function saveFile() {
        $username = $_REQUEST['userName'];
        $newFileName = "";
        $i = 0;
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
                
                $this->data[]=true;
                $this->data[]=$newFileName;
            } else {
                $this->data[] = false;
                $this->errors[] = "An error occurred while uploading the image, try again later.";
                $this->data[] = $this->errors;
            }
        }
    }

}

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
                $this->updateFileUser();
                break;
            case 270:
                $this->modifyFileMenuItem();
                break;
            case 280:
                $this->modifyFileMenu();
                break;
            case 280:
                $this->deleteFile();
                break;
            default:
                $this->data[] = false;
                $this->errors[] = "Action not correct";
                $this->data[] = $this->errors;
                break;
        }

        return $this->data;
    }

    function modifyFileMenu() {
        if (isset($_REQUEST['menu']) && isset($_SESSION['connectedUser'])) {
            if ($_SESSION['role'] == 3) {
                $item = json_decode($_REQUEST['menu']);
                $image = explode("/", $item->image);

                //Check if is the default image to prevent delete it
                if ($image[2] != "image.jpg") {
                    //Delete the previous image
                    $previousImageName = "../../" . $item->image;
                    if (unlink($previousImageName)) {
                        $this->saveFile($item->description);
                    } else {
                        $this->data[] = false;
                        $this->errors[] = "An error occurred while deleting the image, try again later.";
                        $this->data[] = $this->errors;
                    }
                } else {
                    $this->saveFile($item->image);
                }
            } else {
                $this->data[] = false;
                $this->errors[] = "An error occurred while deleting the image, try again later.";
                $this->data[] = $this->errors;
            }
        } else {
            $this->data[] = false;
            $this->errors[] = "An error occurred while deleting the image, try again later.";
            $this->data[] = $this->errors;
        }
    }
    
    function modifyFileMenuItem() {
        if (isset($_REQUEST['item']) && isset($_SESSION['connectedUser'])) {
            if ($_SESSION['role'] == 3) {
                $item = json_decode($_REQUEST['item']);
                $image = explode("/", $item->image);

                //Check if is the default image to prevent delete it
                if ($image[2] != "image.jpg") {
                    //Delete the previous image
                    $previousImageName = "../../" . $item->image;
                    if (unlink($previousImageName)) {
                        $this->saveFile($item->name);
                    } else {
                        $this->data[] = false;
                        $this->errors[] = "An error occurred while deleting the image, try again later.";
                        $this->data[] = $this->errors;
                    }
                } else {
                    $this->saveFile($item->name);
                }
            } else {
                $this->data[] = false;
                $this->errors[] = "An error occurred while deleting the image, try again later.";
                $this->data[] = $this->errors;
            }
        } else {
            $this->data[] = false;
            $this->errors[] = "An error occurred while deleting the image, try again later.";
            $this->data[] = $this->errors;
        }
    }

    function deleteFile() {
        if (isset($_REQUEST['imageToDelete'])) {
            $image = $_REQUEST['imageToDelete'];
            if ($image != null && $image != "") {
                if (unlink("../../" . $image)) {
                    $this->data[] = true;
                } else {
                    $this->data[] = false;
                    $this->errors[] = "An error occurred while deleting the image, try again later.";
                    $this->data[] = $this->errors;
                }
            } else {
                $this->data[] = false;
                $this->errors[] = "An error occurred while deleting the image, try again later.";
                $this->data[] = $this->errors;
            }
        } else {
            $this->data[] = false;
            $this->errors[] = "An error occurred while deleting the image, try again later.";
            $this->data[] = $this->errors;
        }
    }

    function uploadFileMenuItem() {
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
                move_uploaded_file($_FILES['images']['tmp_name'][$key], '../../images/menu_items/' . $newFileName);

                $this->data[] = true;
                $this->data[] = $newFileName;
            } else {
                $this->data[] = false;
                $this->errors[] = "An error occurred while uploading the image, try again later.";
                $this->data[] = $this->errors;
            }
        }
    }

    function updateFileUser() {
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
                    move_uploaded_file($_FILES['images']['tmp_name'][$key], '../../images/users/' . $newFileName);

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

    function saveFile($imageName = "") {
        if ($imageName == "") {
            $imageName = str_replace(' ', '', $_REQUEST['imageName']);
        }

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

                    if (isset($_REQUEST['menuItem'])) {
                        $newFileName = uniqid("menuitem_") . "." . $extension;
                        $locationFile = "../../images/menu_items/";
                    } else if (isset($_REQUEST['menu'])) {
                        $newFileName = uniqid("menu_") . "." . $extension;
                        $locationFile = "../../images/menus/";
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

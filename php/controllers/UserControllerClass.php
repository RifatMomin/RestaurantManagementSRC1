<?php

session_start();

/**
 * toDoClass class
 * it controls the hole server part of the application
 */
//session_start();
require_once "ControllerInterface.php";
require_once "../model/Users/UserClass.php";
require_once "../model/persist/Users/UserADO.php";

class UserController implements ControllerInterface {

    private $helperAdo;
    private $action;
    private $jsonData;
    private $data = [];
    private $errors = [];

    function __construct($action, $jsonData) {
        $this->setAction($action);
        $this->setJsonData($jsonData);
        $this->userADO = new UserADO();
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
            case 10010:
                $this->loginUser();
                break;
            case 10600:
                $this->logOut();
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

    function loginUser() {
        $userObj = json_decode(stripslashes($this->getJsonData()));

        $user = new UserClass(0, $userObj->username, $userObj->password);


        $userList = $this->userADO->findByNickAndPass($user);

        if (count($userList) == 0) {
            $this->data [] = false;
            $this->errors [] = "Invalid Username / Password.";
            $this->data [] = $this->errors;
        } else {
            $this->data [] = true;
            $usersArray = array();

            foreach ($userList as $user) {
                $userObject = new UserClass($user[0], $user[1], $user[2], $user[3], $user[4], $user[5], $user[6], $user[7], $user[8], $user[9], $user[10], $user[11], $user[12]);
                $usersArray[] = $userObject->getAll();
                $_SESSION['connectedUser'] = $userObject->getId();
                $_SESSION['role'] = $userObject->getRole();
            }


            $this->data [] = $usersArray;
        }
    }

    private function sessionControl() {
        $outPutData = array();
        $outPutData[] = true;

        if (isset($_SESSION['connectedUser'])) {
            $outPutData[] = $_SESSION['connectedUser']->getAll();
        } else {
            $outPutData[0] = false;
            $errors[] = "No session opened";
            $outPutData[1] = $errors;
        }

        return $outPutData;
    }
    
    private function logOut(){
        session_destroy();
        
        $this->data [] = true;
    }

}

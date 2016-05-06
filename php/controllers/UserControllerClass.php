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
        switch ($this->getAction()) {
            case 10010:
                $this->loginUser();
                break;
            case 10600:
                $this->logOut();
                break;
            case 10150:
                $this->register();
                break;
            case 10200:
                $this->retrievePasswd();
                break;
            case 10250:
                $this->checkNick();
                break;
            case 10251:
                $this->checkEmail();
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
    
    function checkNick(){
        $json = json_decode(stripslashes($this->getJsonData()));
        
        
        $result = $this->helperAdo->findByNick($json->nick);
        
        
        if($result->rowCount()>0){
            $this->data[]=true;
        }else{
            $this->data[]=false;
        }
        
    }
    
    function checkEmail(){
        $json = json_decode(stripslashes($this->getJsonData()));
        
        
        $result = $this->helperAdo->emailChecking($json->email);       
        
        if($result->rowCount()>0){
            $this->data[]=true;
        }else{
            $this->data[]=false;
        }
    }

    function register(){
        $userObj = json_decode(stripslashes($this->getJsonData()));
        
        $user = new UserClass("", 
                                $userObj->username,
                                $userObj->password , 
                                $userObj->name, 
                                $userObj->surname, 
                                $userObj->email, 
                                $userObj->phone, 
                                $userObj->address, 
                                $userObj->city, 
                                $userObj->zip_code, 
                                "", "");
        
        
        
        $result = $this->helperAdo->create($user);
        
        if($result->rowCount()>0){
            $this->data[]=true;
            $this->data[]= $user->getAll();
        }else{
            $this->data[]=false;
            $this->errors[]="An error occurred while register in the app, come back later and try again.";
            $this->data[]=$this->errors;
            
        }
    }
    
    function loginUser() {
        $userObj = json_decode(stripslashes($this->getJsonData()));

        $user = new UserClass(0, $userObj->username, $userObj->password);


        $userList = $this->helperAdo->findByNickAndPass($user);

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

    function retrievePasswd() {
        $userObj = json_decode(stripslashes($this->getJsonData()));
        $user = new UserClass("", "", "", "", "", $userObj->email);
        $userList = $this->userADO->findByEmail($user);
        
        if ($userList != null) {
            $encrypt = md5(1290 * 3 + $userList->getEmail());
            $message = "Your password reset link has been sent to your e-mail address.";
            $to = $userList->getEmail();
            $subject = "Forget Password";
            $from = 'proinsprov@gmail.com';
            $body = 'Hi, <br/> <br/>Your Membership ID is <br><br>Click here to reset your password http://localhost/RestaurantManagement_1/reset.php?encrypt=' . $encrypt . '&action=reset   <br/> <br/>';
            $headers = "From: " . strip_tags($from) . "\r\n";
            $headers .= "Reply-To: " . strip_tags($from) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            mail($to, $subject, $body, $headers);

            $this->data [] = $userList;
        } else {
            $this->data [] = false;
            $this->errors [] = "Invalid Email.";
            $this->data [] = $this->errors;
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

    private function logOut() {
        session_destroy();

        $this->data [] = true;
    }

}

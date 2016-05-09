<?php

require_once "ControllerInterface.php";
require_once "../model/Users/UserClass.php";
require_once "../model/persist/Users/UserADO.php";
require_once '../lib/swiftmailer-5.x/swift_required.php';

session_start();

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
            case 10230:
                $this->insertClient();
                break;
            case 10250:
                $this->checkNick();
                break;
            case 10251:
                $this->checkEmail();
                break;
            case 10300:
                $this->updatePassword();
                break;
            case 10550:
                $this->checkUserType();
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

    function checkNick() {
        $json = json_decode(stripslashes($this->getJsonData()));


        $result = $this->helperAdo->findByNick($json->nick);


        if ($result->rowCount() > 0) {
            $this->data[] = true;
        } else {
            $this->data[] = false;
        }
    }

    function checkEmail() {
        $json = json_decode(stripslashes($this->getJsonData()));


        $result = $this->helperAdo->emailChecking($json->email);

        if ($result->rowCount() > 0) {
            $this->data[] = true;
        } else {
            $this->data[] = false;
        }
    }

    function register() {
        $userObj = json_decode(stripslashes($this->getJsonData()));

        $user = new UserClass("", $userObj->username, $userObj->password, $userObj->name, $userObj->surname, $userObj->email, $userObj->phone, $userObj->address, $userObj->city, $userObj->zip_code, $userObj->image, "", "");



        $result = $this->helperAdo->create($user);

        $user = new UserClass("", $userObj->username, $userObj->password, $userObj->name, $userObj->surname, $userObj->email, $userObj->phone, $userObj->address, $userObj->city, $userObj->zip_code, $userObj->image, "", "");



        $id = $this->helperAdo->create($user);

        if ($id!= null && $id >0) {  
            $user->setId($id);
            $this->data[] = true;
            $this->data[] = $user->getAll();
        } else {
            $this->data[] = false;
            $this->errors[] = "An error occurred while register in the app, come back later and try again.";
            $this->data[] = $this->errors;
        }
    }

    function insertClient(){
        $userId = json_decode(stripslashes($this->getJsonData()));
        
        $id = (int) $userId->id;
        
        $result = $this->helperAdo->insertClient($id);
        
        
        if($result->rowCount()>0){
            $this->data[]=true;
            $this->data[]=$userId;
        }else{
            $this->data[] = false;
            $this->errors[] = "An error occurred while register in the app, come back later and try again.";
            $this->data[] = $this->errors;
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
                    $_SESSION['connectedUser'] = $userObject;
                    $_SESSION['role'] = $userObject->getRole();
                    $this->data [] = $usersArray;
            }
            
        }
    }

    function retrievePasswd() {

        $helperAdo = new UserADO;
        $userObj = json_decode(stripslashes($this->getJsonData()));
        $user = new UserClass("", "", "", "", "", $userObj->email);
        $userList = $helperAdo->findByEmail($user);

        if ($userList != null) {

            //encriptation
            //$aleatoryString= md5("Lapasswordsecreta");
            $action = md5($userList->getEmail());

            //configuration
            $originEmail = 'cafeteriaproven@gmail.com'; //origin email
            $passwordOriginEmail = 'cafeteria1proven'; //email passowrd
            $nameOriginEmail = 'cafeteria_proven@provensana.com';
            $portSMTPServer = 465; //465 or 25
            $urlSMTPServer = 'smtp.gmail.com'; //url of SMTP server
            $requiresSSLServerSMTP = true;
            //email data
            $addresseeEmail = $userList->getEmail(); //email addressee
            $subject = "Restaurant Retrieve Password"; //email subject
            $body = '<html><body><p>Hi, it seems that you lost your password. Click here to retrieve it: <br><br><a href ="http://localhost/RestaurantManagement_1/reset.php?action=' . $action . '">http://localhost/RestaurantManagement_1/reset.php?action=' . $action . '</a></p></html></body>';
            //send process
            if ($requiresSSLServerSMTP) {
                $transport = Swift_SmtpTransport::newInstance($urlSMTPServer, $portSMTPServer, 'ssl')
                        ->setUsername($originEmail)
                        ->setPassword($passwordOriginEmail);
            } else {
                $transport = Swift_SmtpTransport::newInstance($urlSMTPServer, $portSMTPServer)
                        ->setUsername($originEmail)
                        ->setPassword($passwordOriginEmail);
            }

            $mailerObject = Swift_Mailer::newInstance($transport);
            $emailObject = Swift_Message::newInstance();
            $emailObject->setSubject($subject);
            $emailObject->setTo($addresseeEmail);
            $emailObject->setFrom(array($originEmail => $nameOriginEmail));
            $emailObject->setBody($body, 'text/html'); //body html

            if ($mailerObject->send($emailObject) == 1) {
                $this->data [] = true;
                $this->errors [] = "Sent Successfully.";
                $this->data [] = $this->errors;
            } else {
                echo 'Error sending message';
            }
        } else {
            $this->data [] = false;
            $this->errors [] = "Invalid Email.";
            $this->data [] = $this->errors;
        }
    }

    public function updatePassword() {

        $helperAdo = new UserADO;
        $userObjPasswordArray = json_decode(stripslashes($this->getJsonData()));
        //$userObj = new UserClass($userObjPasswordArray[0], $userObjPasswordArray[1], $userObjPasswordArray[2], $userObjPasswordArray[3], $userObjPasswordArray[4], $userObjPasswordArray[5], $userObjPasswordArray[6], $userObjPasswordArray[7], $userObjPasswordArray[8], $userObjPasswordArray[9], $userObjPasswordArray[10], $userObjPasswordArray[11], $userObjPasswordArray[12]);
        //$userObj = new UserClass($userObjPasswordArray[0]->id, $userObjPasswordArray[0]->username, $userObjPasswordArray[0]->password, $userObjPasswordArray[0]->name, $userObjPasswordArray[0]->surname, $userObjPasswordArray[0]->email, $userObjPasswordArray[0]->phone, $userObjPasswordArray[0]->address, $userObjPasswordArray[0]->city, $userObjPasswordArray[0]->zipCode, $userObjPasswordArray[0]->registerDate, $userObjPasswordArray[0]->role, $userObjPasswordArray[0]->image);
        $userObj = new UserClass("", "", "", "", "", $userObjPasswordArray[0]->email);
        $newPasword = $userObjPasswordArray[1];
        $url = $userObjPasswordArray[2];
        
        $email=$userObjPasswordArray[0]->email;
                
        $userList = $helperAdo->findByEmail($userObj);
       
        if ($userList != null) {

            //encrypt password to compare with url string
            $encrypt = md5($email);
            
            //compares that the url is actually valid
            if (strcmp($url, $encrypt) == 0) {
                $userList = $helperAdo->resetPassword($userObj, $newPasword);
                var_dump($userList);
                if ($userList != null) {
                    $this->data [] = true;
                    $this->errors [] = "Password updated";
                    $this->data [] = $this->errors;
                } else {
                    $this->data [] = false;
                    $this->errors [] = "Password could not be updated";
                    $this->data [] = $this->errors;
                }
            } else {
                $this->data [] = false;
                $this->errors [] = "Access not allowed";
                $this->data [] = $this->errors;
            }
        } else {
            $this->data [] = false;
            $this->errors [] = "Email not valid";
            $this->data [] = $this->errors;
        }
    }

    private function logOut() {
        session_destroy();

        $this->data [] = true;
    }

    private function checkUserType() {
        if (isset($_SESSION['connectedUser'])) {
            $userInfo = $_SESSION['connectedUser'];


            $this->data[] = true;
            $this->data[] = $userInfo->getRole();
        } else {
            $this->data[] = false;
            $this->errors[] = "There's no session opened.";
            $this->data[] = $this->errors;
        }
    }

}

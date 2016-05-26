<?php
/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */

class ClientClass extends UserClass {

    
    //attributes+
    private $userId;
    private $clientId;
    
    //constructor
    function __construct() {  
        $this->userId = $userId;
        $this->clientId = $clientId;  
    }  
    
    //getters and setters
    function getUserId() {
        return $this->userId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getClientId() {  
         return $this->clientId;  
    }  

    public function setClientId($clientId) {
        $this->clientId = clientId;
    }
    
    public function toString() {  
        $data = "Id: " . $this->getId() . "ClientId: " . $this->getClientId() .", Username: " . $this->getUsername(). ", Password: " . $this->getPassword(). ", Name: " . $this->getName(). ", Surname: " . $this->getSurname(). ", Email: " . $this->getEmail(). ", Phone: " . $this->getPhone(). ", Address: " . $this->getAddress();  
        $data .= ", City: " .$this->getCity() . ", ZipCode: " . $this->zipCode(). ", Register Date: " . $this->getRegisterDate();    
        return $data;  
    }  
}
?>

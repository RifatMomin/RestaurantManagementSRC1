<?php
/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */

class WaiterClass extends UserClass {

    //attributes
    private $userId;
    private $waiterId;
    
    //constructor
    function __construct($userId, $waiterId) {  
        $this->userId = $userId;
        $this->waiterId = $waiterId;  
    }  
    
    //getters
    function getUserId() {
        return $this->userId;
    }
    
    public function getWaiterId() {  
       return $this->waiterId;  
    }  
    
    //setters
    function setUserId($userId) {
        $this->userId = $userId;
    }
    
    public function setWaiterId($waiterId) {
        $this->waiterId = $waiterId;
    }
    
    public function toString() {  
        $data = "Id: " . $this->getId() . "WaiterId: " . $this->getWaiterId() .", Username: " . $this->getUsername(). ", Password: " . $this->getPassword(). ", Name: " . $this->getName(). ", Surname: " . $this->getSurname(). ", Email: " . $this->getEmail(). ", Phone: " . $this->getPhone(). ", Address: " . $this->getAddress();  
        $data .= ", City: " .$this->getCity() . ", ZipCode: " . $this->zipCode(). ", Register Date: " . $this->getRegisterDate();    
        return $data;  
    }  
}
?>

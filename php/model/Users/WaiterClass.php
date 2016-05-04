<?php
/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */
 require_once "../EntityInterface.php";
class WaiterClass extends UserClass {

    //attributes
    private $waiterId;
    
    //constructor
    function __construct() {  
        parent::__construct($id, $username, $password, $name, $username, $email, $phone, $address, $city, $zipCode, $registerDate, $role);  
        $this->waiterId = $waiterId;  
    }  
    
    //getters
    public function getWaiterId() {  
         return $this->waiterId;  
    }  
    
    //setters
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

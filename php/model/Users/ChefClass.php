<?php
/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */

class ChefClass extends UserClass{

    
    //attributes
    private $userId;
    private $chefId;
    private $chefLevel;
    
    //constructor
    function __construct() {  
        $this->userId = $userId;
        $this->chefId = $chefId;
        $this->chefLevel = $chefLevel;
    }  
    
    function getChefId() {
        return $this->chefId;
    }

    function getChefLevel() {
        return $this->chefLevel;
    }

    function setChefId($chefId) {
        $this->chefId = $chefId;
    }

    function setChefLevel($chefLevel) {
        $this->chefLevel = $chefLevel;
    }

        public function toString() {  
        $data = "Id: " . $this->getId() . "Chef Id: " . $this->getChefId() . "Chef Level: " . $this->getChefLevel() .", Username: " . $this->getUsername(). ", Password: " . $this->getPassword(). ", Name: " . $this->getName(). ", Surname: " . $this->getSurname(). ", Email: " . $this->getEmail(). ", Phone: " . $this->getPhone(). ", Address: " . $this->getAddress();  
        $data .= ", City: " .$this->getCity() . ", ZipCode: " . $this->zipCode(). ", Register Date: " . $this->getRegisterDate(). ", Role: " . $this->getRole();    
        return $data;  
    }  
}
?>

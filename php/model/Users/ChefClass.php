<?php
/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */
 require_once "../EntityInterface.php";
class ChefClass extends UserClass {

    
    //attributes
    private $chefId;
    private $levelChef;
    
    //constructor
    function __construct() {  
        parent::__construct($id, $username, $password, $name, $username, $email, $phone, $address, $city, $zipCode, $registerDate, $role);  
        $this->chefId = $chefId;
        $this->levelChef = $levelChef;
    }  
    
    //getters
    public function getChefId() {  
     return $this->chefId;  
    }  
    
    public function getChefLevel(){
       return $this->levelChef;
    }
    
    //setters
    public function setChefId($chefId) {
        $this->chefId = $chefId;
    }
    
    public function setChefLevel($levelChef) {
        $this->levelChef = $levelChef;
    }
    
    public function toString() {  
        $data = "Id: " . $this->getId() . "Chef Id: " . $this->getChefId() . "Chef Level: " . $this->getChefLevel() .", Username: " . $this->getUsername(). ", Password: " . $this->getPassword(). ", Name: " . $this->getName(). ", Surname: " . $this->getSurname(). ", Email: " . $this->getEmail(). ", Phone: " . $this->getPhone(). ", Address: " . $this->getAddress();  
        $data .= ", City: " .$this->getCity() . ", ZipCode: " . $this->zipCode(). ", Register Date: " . $this->getRegisterDate(). ", Role: " . $this->getRole();    
        return $data;  
    }  
}
?>

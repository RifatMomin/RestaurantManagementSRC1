<?php

/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */

class AdminClass extends UserClass {


    //attributes
    private $clientId;

    //constructor
    function __construct() {
        parent::__construct($id, $username, $password, $name, $username, $email, $phone, $address, $city, $zipCode, $registerDate, $role);
        $this->clientId = $clientId;
    }

    //getters
    public function getClientId() {
        return $this->clientId;
    }

    //setters
    public function setAdminId($adminId) {
        $this->adminId = $adminId;
    }

    public function toString() {
        $data = "Id: " . $this->getId() . "AdminId: " . $this->getAdminId() . ", Username: " . $this->getUsername() . ", Password: " . $this->getPassword() . ", Name: " . $this->getName() . ", Surname: " . $this->getSurname() . ", Email: " . $this->getEmail() . ", Phone: " . $this->getPhone() . ", Address: " . $this->getAddress();
        $data .= ", City: " . $this->getCity() . ", ZipCode: " . $this->zipCode() . ", Register Date: " . $this->getRegisterDate() . "Role: " . $this->getRole();
        return $data;
    }

}

?>

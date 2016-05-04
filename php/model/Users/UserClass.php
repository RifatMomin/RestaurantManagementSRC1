<?php

/** userClass.php
 * Entity userClass
 * autor  Roberto Plana
 * version 2012/09
 */
require_once "../model/EntityInterface.php";

class UserClass implements EntityInterface {

    //attributes
    private $id;
    private $username;
    private $password;
    private $name;
    private $surname;
    private $email;
    private $phone;
    private $address;
    private $city;
    private $zipCode;
    private $registerDate;
    private $role;

    function __construct($id = "", $username = "", $password = "", $name = "", $surname = "", $email = "", $phone = "", $address = "", $city = "", $zipCode = "", $registerDate = "", $role = "") {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->city = $city;
        $this->zipCode = $zipCode;
        $this->registerDate = $registerDate;
        $this->role = $role;
    }

    //getters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->username;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getCity() {
        return $this->city;
    }

    public function getZipCode() {
        return $this->zipcode;
    }

    public function getRegisterDate() {
        return $this->registerDate;
    }

    public function getRole() {
        return $this->role;
    }

    //setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }

    public function setRegisterDate($registerDate) {
        $this->registerDate = $registerDate;
    }

    public function setRole($registerDate) {
        $this->role = $role;
    }

    //methods
    public function getAll() {
        $data = array();
        //$data["id"] = $this->id;
        $data["username"] = $this->username;
        //$data["password"] = $this->password;
        $data["name"] = $this->name;
        $data["surname"] = $this->surname;
        $data["email"] = $this->email;
        $data["phone"] = $this->phone;
        $data["address"] = $this->address;
        $data["city"] = $this->city;
        $data["zipCode"] = $this->zipCode;
        $data["registerDate"] = $this->registerDate;
        //$data["role"] = $this->role;

        return $data;
    }

    public function toString() {
        $toString = "userClass[id=" . $this->id . "][username=" . $this->getUsername() . "][password=" . $this->getPassword() . "][name=" . $this->getName() . "][surname=" . $this->getSurname() . "][email=" . $this->mail . "][phone=" . $this->getPhone() . "][address=" . $this->getAddress() . "][city=" . $this->getCity() . "][zipCode=" . $this->getZipCode() . "][registerDate=" . $this->getRegisterDate() . "][role=" . $this->getRole() . "]";
        return $toString;
    }

}

?>

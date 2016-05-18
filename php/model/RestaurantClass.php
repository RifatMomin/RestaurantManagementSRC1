<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RestaurantClass
 *
 * @author Alumne
 */
class RestaurantClass {

    //attributes
    private $id;
    private $CIF;
    private $name;
    private $address;
    private $city;
    private $zipCode;
    private $phone1;
    private $phone2;
    private $email;
    private $description;
    
    function __construct($id="", $CIF="", $name="", $address="", $city="", $zipCode="", $phone1="", $phone2="", $email="", $description="") {
        $this->id = $id;
        $this->CIF = $CIF;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->zipCode = $zipCode;
        $this->phone1 = $phone1;
        $this->phone2 = $phone2;
        $this->email = $email;
        $this->description = $description;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getCIF() {
        return $this->CIF;
    }

    public function getName() {
        return $this->name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getCity() {
        return $this->city;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function getPhone1() {
        return $this->phone1;
    }

    public function getPhone2() {
        return $this->phone2;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCIF($CIF) {
        $this->CIF = $CIF;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }

    public function setPhone1($phone1) {
        $this->phone1 = $phone1;
    }

    public function setPhone2($phone2) {
        $this->phone2 = $phone2;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getAll() {
        $data = array();
        $data["id"] = $this->id;
        $data["cif"] = $this->CIF;
        $data["name"] = $this->name;
        $data["address"] = $this->address;
        $data["city"] = $this->city;
        $data["zipCode"] = $this->zipCode;
        $data["phone1"] = $this->phone1;
        $data["phone2"] = $this->phone2;
        $data["email"] = $this->email;
        $data["description"] = $this->description;
        

        return $data;
    }
    

}

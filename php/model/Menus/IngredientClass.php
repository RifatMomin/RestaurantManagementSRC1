<?php

/**
 * Description of IngredientClass
 *
 * @author victor
 */

require_once "../EntityInterface.php";

class IngredientClass implements EntityInterface{
    private $id;
    private $name;
    private $price;
    
    function __construct($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price= $price;
    }
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

        
    function getAll(){
        $data = [];
        $data['id'] = $this->getId();
        $data['name'] = $this->getName();
        $data['price'] = $this->getPrice();
        
        return $data;
    }
}

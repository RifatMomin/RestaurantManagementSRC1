<?php

/**
 * Description of MealClass
 *
 * @author victor
 */
require_once "../model/EntityInterface.php";

class MenuItemClass implements EntityInterface{
    private $itemId;
    private $name;
    private $image;
    private $price;
    
    function __construct($itemId, $name, $image, $price) {
        $this->itemId = $itemId;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
    }
    
    public function getItemId() {
        return $this->itemId;
    }

    public function getName() {
        return $this->name;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    
    function getAll(){
        $data = [];
        
        $data['itemId'] = $this->getItemId();
        $data['name'] = $this->getName();
        $data['image'] = $this->getImage();
        $data['price'] = $this->getPrice();
        return $data;
    }

}

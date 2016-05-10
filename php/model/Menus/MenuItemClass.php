<?php

/**
 * Description of MenuItemObj
 *
 * @author Rifat
 */
require_once "../model/EntityInterface.php";

class MenuItemClass implements EntityInterface{
    private $itemId;
    private $courseId;
    private $name;
    private $image;
    private $price;
    
    function __construct($itemId, $courseId, $name, $image, $price) {
        $this->itemId = $itemId;
        $this->courseId = $courseId;
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
    }

    function getItemId() {
        return $this->itemId;
    }

    function getCourseId() {
        return $this->courseId;
    }

    function getName() {
        return $this->name;
    }

    function getImage() {
        return $this->image;
    }

    function getPrice() {
        return $this->price;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    function setCourseId($courseId) {
        $this->courseId = $courseId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function getAll(){
        $data = [];
        
        $data['itemId'] = $this->getItemId();
        $data['courseId'] = $this->getCourseId();
        $data['name'] = $this->getName();
        $data['image'] = $this->getImage();
        $data['price'] = $this->getPrice();
        return $data;
    }

}

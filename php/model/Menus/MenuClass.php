<?php

/**
 * Description of MealClass
 *
 * @author victor
 */
require_once "../model/EntityInterface.php";

class MenuClass implements EntityInterface {

    private $menuId;
    private $name;
    private $items = [];
    private $active;
    private $personalized;
    private $description;
    private $image;
    private $price;

    function __construct($menuId,$name, $items, $activate, $personalized, $description, $image, $price) {
        $this->name = $name;
        $this->menuId = $menuId;
        $this->items = $items;
        $this->active = $activate;
        $this->personalized = $personalized;
        $this->description = $description;
        $this->image = $image;
        $this->price = $price;
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

        
    function getMenuId() {
        return $this->menuId;
    }

    function getItems() {
        return $this->items;
    }

    function getActive() {
        return $this->active;
    }

    function getPersonalized() {
        return $this->personalized;
    }

    function getDescription() {
        return $this->description;
    }

    function getImage() {
        return $this->image;
    }

    function getPrice() {
        return $this->price;
    }

    function setMenuId($menuId) {
        $this->menuId = $menuId;
    }

    function setItems($items) {
        $this->items = $items;
    }

    function setActive($activate) {
        $this->active = $activate;
    }

    function setPersonalized($personalized) {
        $this->personalized = $personalized;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setImage($image) {
        $this->image = $image;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function getAll() {
        $data = [];

        $data['menuId'] = $this->getMenuId();
        $data['items'] = $this->getItems();
        $data['active'] = $this->getActive();
        $data['personalized'] = $this->getPersonalized();
        $data['description'] = $this->getDescription();
        $data['image'] = $this->getImage();
        $data['price'] = $this->getPrice();
        
        return $data;
    }

}

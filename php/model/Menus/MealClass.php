<?php

/**
 * Description of MealClass
 *
 * @author victor
 */
require_once "../model/EntityInterface.php";

class MenuClass implements EntityInterface{
    private $menuId;
    private $first;
    private $second;
    private $dessert;
    private $drink;
    private $image;
    private $price;
    
    function __construct($menuId, $first, $second, $dessert, $drink, $image, $price) {
        $this->menuId = $menuId;
        $this->first = $first;
        $this->second = $second;
        $this->dessert = $dessert;
        $this->drink = $drink;
        $this->image = $image;
        $this->price = $price;
    }
    
    public function getMenuId() {
        return $this->menuId;
    }

    public function getFirst() {
        return $this->first;
    }

    public function getSecond() {
        return $this->second;
    }

    public function getDessert() {
        return $this->dessert;
    }

    public function getDrink() {
        return $this->drink;
    }

    public function getImage() {
        return $this->image;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setMenuId($menuId) {
        $this->menuId = $menuId;
    }

    public function setFirst($first) {
        $this->first = $first;
    }

    public function setSecond($second) {
        $this->second = $second;
    }

    public function setDessert($dessert) {
        $this->dessert = $dessert;
    }

    public function setDrink($drink) {
        $this->drink = $drink;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    
    function getAll(){
        $data = [];
        
        $data['menuId'] = $this->getMenuId();
        $data['first'] = $this->getFirst();
        $data['second'] = $this->getSecond();
        $data['dessert'] = $this->getDessert();
        $data['drink'] = $this->getDrink();
        $data['image'] = $this->getImage();
        $data['price'] = $this->getPrice();
        return $data;
    }

}

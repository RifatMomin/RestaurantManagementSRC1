<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderMenuItemClass
 *
 * @author victor
 */
require_once '../EntityInterface.php';

class MenuItemIngredientClass implements EntityInterface{
    private $menuItemIngredientId;
    private $itemId;
    private $ingredientId;
    private $quantity;
    
    function __construct($menuItemIngredientId, $itemId, $ingredientId, $quantity) {
        $this->menuItemIngredientId = $menuItemIngredientId;
        $this->itemId = $itemId;
        $this->ingredientId = $ingredientId;
        $this->quantity = $quantity;

    }

    public function getMenuItemIngredientId() {
        return $this->menuItemIngredientId;
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function getIngredientId() {
        return $this->ingredientId;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setMenuItemIngredientId($menuItemIngredientId) {
        $this->menuItemIngredientId = $menuItemIngredientId;
    }

    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    public function setIngredientId($ingredientId) {
        $this->ingredientId = $ingredientId;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

        
    function getAll(){
        $data = [];
        
        $data['menuItemIngredientId'] = $this->getMenuItemIngredientId();
        $data['itemId'] = $this->getItemId();
        $data['ingredientId'] = $this->getIngredientId();
        $data['quantity'] = $this->getQuantity();
        
        return $data;
    }
}

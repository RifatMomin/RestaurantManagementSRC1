<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderMenuItemClass
 *
 * @author Rifat
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
    
    function getMenuItemIngredientId() {
        return $this->menuItemIngredientId;
    }

    function getItemId() {
        return $this->itemId;
    }

    function getIngredientId() {
        return $this->ingredientId;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function setMenuItemIngredientId($menuItemIngredientId) {
        $this->menuItemIngredientId = $menuItemIngredientId;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    function setIngredientId($ingredientId) {
        $this->ingredientId = $ingredientId;
    }

    function setQuantity($quantity) {
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

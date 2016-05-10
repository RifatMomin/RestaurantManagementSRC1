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

class MenuMenuItemClass implements EntityInterface{
    private $menuMenuItemId;
    private $menuId;
    private $itemId;
    
    function __construct($menuMenuItemId, $menuId, $itemId) {
        $this->menuMenuItemId = $menuMenuItemId;
        $this->menuId = $menuId;
        $this->itemId = $itemId;
    }
    
    function getMenuMenuItemId() {
        return $this->menuMenuItemId;
    }

    function getMenuId() {
        return $this->menuId;
    }

    function getItemId() {
        return $this->itemId;
    }

    function setMenuMenuItemId($menuMenuItemId) {
        $this->menuMenuItemId = $menuMenuItemId;
    }

    function setMenuId($menuId) {
        $this->menuId = $menuId;
    }

    function setItemId($itemId) {
        $this->itemId = $itemId;
    }
        
    function getAll(){
        $data = [];
        
        $data['menuMenuItemId'] = $this->getMenuMenuItemId();
        $data['menuId'] = $this->getMenuId();
        $data['itemId'] = $this->getItemId();

        return $data;
    }
}

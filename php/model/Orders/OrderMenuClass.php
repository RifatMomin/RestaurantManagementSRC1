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

class MenuMenuItemClass implements EntityInterface{
    private $menuMenuItemId;
    private $itemId;
    private $menuId;
    
    function __construct($menuMenuItemId, $itemId, $menuId) {
        $this->menuMenuItemId = $menuMenuItemId;
        $this->itemId = $itemId;
        $this->menuId = $menuId;
    }

    public function getMenuMenuItemId() {
        return $this->menuMenuItemId;
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function getMenuId() {
        return $this->menuId;
    }

    public function setMenuMenuItemId($menuMenuItemId) {
        $this->menuMenuItemId = $menuMenuItemId;
    }

    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    public function setMenuId($menuId) {
        $this->menuId = $menuId;
    }

    function getAll(){
        $data = [];
        
        $data['$menuMenuItemId'] = $this->getMenuMenuItemId();
        $data['orderId'] = $this->getOrderId();
        $data['menuId'] = $this->getMenuId();
        
        return $data;
    }
}

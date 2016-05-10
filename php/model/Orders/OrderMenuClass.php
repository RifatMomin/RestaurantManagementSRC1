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

class OrderMenuClass implements EntityInterface{
    private $orderIdMenuId;
    private $orderId;
    private $menuId;
    
    function __construct($orderIdMenuId, $orderId, $menuId) {
        $this->orderIdMenuId = $orderIdMenuId;
        $this->orderId = $orderId;
        $this->menuId = $menuId;
    }

    function getOrderIdMenuId() {
        return $this->orderIdMenuId;
    }

    function getOrderId() {
        return $this->orderId;
    }

    function getMenuId() {
        return $this->menuId;
    }

    function setOrderIdMenuId($orderIdMenuId) {
        $this->orderIdMenuId = $orderIdMenuId;
    }

    function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    function setMenuId($menuId) {
        $this->menuId = $menuId;
    }

    function getAll(){
        $data = [];
        
        $data['orderIdMenuId'] = $this->getOrderIdMenuId();
        $data['orderId'] = $this->getOrderId();
        $data['menuId'] = $this->getMenuId();
        
        return $data;
    }
}

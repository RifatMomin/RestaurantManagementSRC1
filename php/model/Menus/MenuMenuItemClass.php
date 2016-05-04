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
    private $orderItemId;
    private $orderId;
    private $menuId;
    
    function __construct($orderItemId, $orderId, $menuId) {
        $this->orderItemId = $orderItemId;
        $this->orderId = $orderId;
        $this->menuId = $menuId;
    }

    function getOrderItemId() {
        return $this->orderItemId;
    }

    function getOrderId() {
        return $this->orderId;
    }

    function getMenuId() {
        return $this->menuId;
    }

    function setOrderItemId($orderItemId) {
        $this->orderItemId = $orderItemId;
    }

    function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    function setMenuId($menuId) {
        $this->menuId = $menuId;
    }

    function getAll(){
        $data = [];
        
        $data['orderItemId'] = $this->getOrderItemId();
        $data['orderId'] = $this->getOrderId();
        $data['menuId'] = $this->getMenuId();
        
        return $data;
    }
}

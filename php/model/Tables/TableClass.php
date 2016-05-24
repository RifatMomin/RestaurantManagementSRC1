<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TableLocationClass
 *
 * @author Alumne
 */
class TableClass {
    
    //attributes
    private $tableId;
    private $type;
    private $status;
    private $location;
    private $capacity;
    
    function __construct($tableId="", $type="", $status="", $location="", $capacity="") {
        $this->tableId = $tableId;
        $this->type = $type;
        $this->status = $status;
        $this->location = $location;
        $this->capacity = $capacity;
    }

    function getTableId() {
        return $this->tableId;
    }

    function getType() {
        return $this->type;
    }

    function getStatus() {
        return $this->status;
    }

    function getLocation() {
        return $this->location;
    }

    function getCapacity() {
        return $this->capacity;
    }

    function setTableId($tableId) {
        $this->tableId = $tableId;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setCapacity($capacity) {
        $this->capacity = $capacity;
    }
 
    function getAll(){
        $data = [];
        
        $data['tableId'] = $this->getTableId();
        $data['type'] = $this->getType();
        $data['status'] = $this->getStatus();
        $data['location'] = $this->getLocation();
        $data['capacity'] = $this->getCapacity();
        
        return $data;
    }

}

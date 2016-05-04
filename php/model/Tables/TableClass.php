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
    private $status;
    private $type;
    private $location;
    private $capacity;
    
    function __construct($tableId, $status, $type, $location, $capacity) {
        $this->tableId = $tableId;
        $this->status = $status;
        $this->type = $type;
        $this->location = $location;
        $this->capacity = $capacity;
    }

    //getters
    public function getTableId() {
        return $this->tableId;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getType() {
        return $this->type;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getCapacity() {
        return $this->capacity;
    }
    
    //setters
    public function setTableId($tableId) {
        $this->tableId = $tableId;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setCapacity($capacity) {
        $this->capacity = $capacity;
    }
    
    

}

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
    private $table_id;
    private $type_id;
    private $table_status;
    private $table_location;
    private $capacity;
    private $active;
    
    function __construct($table_id, $type_id, $table_status, $table_location, $capacity, $active) {
        $this->table_id = $table_id;
        $this->type_id = $type_id;
        $this->table_status = $table_status;
        $this->table_location = $table_location;
        $this->capacity = $capacity;
        $this->active = $active;
    }

    function getTable_id() {
        return $this->table_id;
    }

    function getType_id() {
        return $this->type_id;
    }

    function getTable_status() {
        return $this->table_status;
    }

    function getTable_location() {
        return $this->table_location;
    }

    function getCapacity() {
        return $this->capacity;
    }
    
    function getActive(){
        return $this->active;
    }

    function setTable_id($table_id) {
        $this->table_id = $table_id;
    }

    function setType_id($type_id) {
        $this->type_id = $type_id;
    }

    function setTable_status($table_status) {
        $this->table_status = $table_status;
    }

    function setTable_location($table_location) {
        $this->table_location = $table_location;
    }

    function setCapacity($capacity) {
        $this->capacity = $capacity;
    }
    function setActive($active){
        $this->active = $active;
    }

    function getAll(){
        $data = [];
        
        $data['table_id'] = $this->getTable_id();
        $data['type_id'] = $this->getType_id();
        $data['$table_status'] = $this->getTable_status();
        $data['table_location'] = $this->getTable_location();
        $data['capacity'] = $this->getCapacity();
        $data['active'] = $this->getActive();
        return $data;
    }

}

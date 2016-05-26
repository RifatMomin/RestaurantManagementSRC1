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
class TableTypeClass {
    
    //attributes
    private $type_id;
    private $name_type;
    
    //constructor
    function __construct($type_id, $name_type) {  
        $this->type_id = $type_id;
        $this->name_type = $name_type;
    } 
    
    //getters
    public function getTableTypeId(){
        return $this->type_id;
    }
    
    public function getNameType(){
        return $this->name_type;
    }
    
    //setters
    public function setTableTypeId($type_id){
        $this->type_id = $type_id;
    }
    
    public function setNameType($name_type){
        $this->name_type=$name_type;
    }
}

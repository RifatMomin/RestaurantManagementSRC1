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
    private $id;
    private $name;
    
    //constructor
    function __construct() {  
        $this->id = $id;
        $this->name=$name;
    } 
    
    //getters
    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }
    
    //setters
    public function setId(){
        $this->id=$id;
    }
    
    public function setName(){
        $this->name=$name;
    }
}

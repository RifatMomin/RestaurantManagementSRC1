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
class TableLocationClass{
    
    //attributes
    private $location_id;
    private $name_location;
    
    //constructor
    function __construct($location_id, $name_location) {  
        $this->location_id = $location_id;
        $this->name_location=$name_location;
    } 
    
    //getters
    public function getLocationId(){
        return $this->location_id;
    }
    
    public function getNameLocation(){
        return $this->name_location;
    }
    
    //setters
    public function setLocationId(){
        $this->location_id=$location_id;
    }
    
    public function setNameLocation(){
        $this->name_location=$name_location;
    }
}

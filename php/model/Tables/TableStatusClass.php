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
class TableStatusClass {
    
    //attributes
    private $table_status_id;
    private $name_status;
    
    //constructor
    function __construct($table_status_id, $name_status) {  
        $this->table_status_id = $table_status_id;
        $this->name_status = $name_status;
    } 
    
    //getters
    public function getTableStatusId(){
        return $this->table_status_id;
    }
    
    public function getNameStatus(){
        return $this->name_status;
    }
    
    //setters
    public function setTableStatusId($table_status_id){
        $this->table_status_id=$table_status_id;
    }
    
    public function setNameStatus($name_status){
        $this->name_status = $name_status;
    }
}

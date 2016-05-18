<?php

/**
 * Description of CourseClass
 *
 * @author Alumne
 */

require_once "../model/EntityInterface.php";

class CourseClass implements EntityInterface{
    private $id;
    private $name;
    
    function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getAll(){
        $data = [];
        
        $data['id'] = $this->getId();
        $data['name'] = $this->getName();
        
        return $data;
    }

}

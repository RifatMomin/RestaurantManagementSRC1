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
    private $priority;
    
    function __construct($id, $name, $priority) {
        $this->id = $id;
        $this->name = $name;
        $this->priority = $priority;
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }
    
    function getPriority() {
        return $this->priority;
    }
    
    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }
    
    function setPriority($priority) {
        $this->priority = $priority;
    }
    
    function getAll(){
        $data = [];
        
        $data['id'] = $this->getId();
        $data['name'] = $this->getName();
        $data['priority'] = $this->getPriority();
        
        return $data;
    }

}

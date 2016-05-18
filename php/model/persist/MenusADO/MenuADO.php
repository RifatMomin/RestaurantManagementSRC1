<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuADO
 *
 * @author victor
 */
require_once "../model/persist/DBConnect.php";
require_once "../model/Menus/MenuClass.php";
require_once "../model/persist/EntityInterfaceADO.php";

class MenuADO implements EntityInterfaceADO {

    //Queries
    const SELECT_ALL = 'SELECT * FROM menu WHERE personalized = 1';
//    const INSERT = "INSERT INTO ProjectDAW2_Restaurant. menu (menu_id, first, second, dessert, image, price ) VALUES (?, ?, ?, ?, ?, ?)";
//    const SELECT_ID = "SELECT * FROM menu WHERE menu_id = ?";

    private $dbSource;
    private $meal;

    function __construct() {
        try {
            $this->dbSource = DBConnect::getInstance();
        } catch (Exception $ex) {
            error_log("Error in DBCONNECT: " . $e->getMessage() . " ");
            die();
        }
    }

    public function create($entity) {
        $this->meal = new MealClass($entity->getMealId(), $entity->getCourse(), $entity->getName(), $entity->getPrice());
        //:course_id,:meal_name,:meal_price,:meal_image
        $vector = [ ":course_id" => $entity->getCourse(),
            ":meal_name" => $entity->getName(),
            ":meal_image" => $entity->getImage(),
            ":meal_price" => $entity->getPrice()
        ];

        return $this->dbSource->executionInsert(self::INSERT, $vector);
    }

    public function delete($entity) {
        
    }

    public function update($entity) {
        
    }

    public function findAll() {
        return $result = $this->dbSource->execution(self::SELECT_ALL, $vector = []);
    }
    

}

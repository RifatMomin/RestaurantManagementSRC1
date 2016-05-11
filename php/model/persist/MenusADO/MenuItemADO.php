<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MenuItemADO
 *
 * @author Rifat Momin
 * 
 */
require_once "../model/persist/DBConnect.php";
require_once "../model/Menus/MenuItemClass.php";
require_once "../model/persist/EntityInterfaceADO.php";

class MenuItemADO implements EntityInterfaceADO {

    //Queries
    const SELECT_ALL = "SELECT * FROM menu_item";
    const INSERT = "INSERT INTO ProjectDAW2_Restaurant.menu_item (item_id, course_id, name, image) VALUES (?, ?, ?, ?)";
    const SELECT_ID = "SELECT * FROM menu_item WHERE item_id = ?";
    const DELETE = "DELETE FROM menu_item WHERE item_id = ?";
    const UPDATE = "UPDATE menu_item SET course_id = ?, name = ?, image = ? WHERE name = ?";

    private $dbSource;
    private $menuItem;

    function __construct() {
        try {
            $this->dbSource = DBConnect::getInstance();
        } catch (Exception $ex) {
            error_log("Error in DBCONNECT: " . $e->getMessage() . " ");
            die();
        }
    }

    public function create($entity) {
        $this->menuItem = new MenuItemClass($entity->getItemId(), $entity->getCourseId(), $entity->getName(), $entity->getImage(), $entity->getPrice());
        //:course_id,:meal_name,:meal_price,:meal_image
        $vector = [ "itemId" => $entity->getItemId(),
            "courseId" => $entity->getCourseId(),
            "name" => $entity->getName(),
            "image" => $entity->getImage(),
            "price" => $entity->getPrice()
        ];

        return $this->dbSource->executionInsert(self::INSERT, $vector);
    }

    public function delete($entity) {
        $this->menuItem = new MenuItemClass($entity->getItemId(), $entity->getCourseId(), $entity->getName(), $entity->getImage(), $entity->getPrice());
        //:course_id,:meal_name,:meal_price,:meal_image
        $vector = [ "itemId" => $entity->getItemId(),
        ];

        return $this->dbSource->executionInsert(self::DELETE, $vector);
    }

    public function update($entity) {
        $this->menuItem = new MenuItemClass($entity->getItemId(), $entity->getCourseId(), $entity->getName(), $entity->getImage(), $entity->getPrice());
        //:course_id,:meal_name,:meal_price,:meal_image
        $vector = [ "itemId" => $entity->getItemId(),
        ];

        return $this->dbSource->executionUpdate(self::UPDATE, $vector);
    }

    public function findAll() {
        return $this->dbSource->execution(self::SELECT_ALL, $vector = []);
    }

}

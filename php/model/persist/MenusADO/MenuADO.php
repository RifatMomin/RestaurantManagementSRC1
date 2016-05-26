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
    const SELECT_ALL_CLIENTS = 'SELECT * FROM menu WHERE personalized = 1 and `active` = 1';
    const INSERT_MENU = "INSERT INTO `menu` (`name`,`image`, `price`, `description`, `personalized`, `active`) VALUES (?, ?, ?, ?, ?, ?)";
    const INSERT_MENU_HAS_ITEM = "INSERT INTO `menu_has_item` (`menu_id`, `item_id`) VALUES (?, ?)";
    const UPDATE_ACTIVE = "UPDATE `menu` SET active = ? WHERE `menu_id` = ?";
    const UPDATE = "UPDATE `menu` SET `image`=?,`price`=?,`description`=?, `name` = ? WHERE `menu_id`=?";
    const DELETE_ITEMS_MENU = "DELETE FROM `menu_has_item` WHERE `menu_id` = ?";

    private $dbSource;
    private $meal;

    function __construct() {
        try {
            $this->dbSource = DBConnect::getInstance();
        } catch (Exception $ex) {
            error_log("Error in DBCONNECT: " . $ex . " ");
            die();
        }
    }

    public function insertItemsMenu($item, $menuId) {
        return $this->dbSource->execution(self::INSERT_MENU_HAS_ITEM, $array = [$menuId, $item->getItemId()]);
    }

    public function updateActive($active, $menuId) {
        return $this->dbSource->execution(self::UPDATE_ACTIVE, $array = [$active, $menuId]);
    }

    public function create($menu) {
        //`image`, `price`, `description`, `personalized`, `active`
        $vector = [
            $menu->getName(),
            $menu->getImage(),
            $menu->getPrice(),
            $menu->getDescription(),
            $menu->getPersonalized(),
            $menu->getActive()
        ];

        return $this->dbSource->executeTransaction(self::INSERT_MENU, $vector);
    }

    public function deleteItemsFromMenu($menuId) {
        return $this->dbSource->execution(self::DELETE_ITEMS_MENU, $array = [$menuId]);
    }

    public function delete($entity) {
        
    }

    public function update($menu) {
        $array = [$menu->getImage(),
            $menu->getPrice(),
            $menu->getDescription(),
            $menu->getName(),
            $menu->getMenuId()
        ];
        return $this->dbSource->execution(self::UPDATE, $array);
    }

    public function findAll() {
        return $result = $this->dbSource->execution(self::SELECT_ALL, $vector = []);
    }

    public function findAllMenusClients() {
        return $result = $this->dbSource->execution(self::SELECT_ALL_CLIENTS, $vector = []);
    }

}

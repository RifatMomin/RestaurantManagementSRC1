<?php

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
    const SELECT_ALL_WITH_INGREDIENTS = "SELECT mi.*, c.*, item_ingredient.*, GROUP_CONCAT(ing.ingredient_name SEPARATOR ';') ingredients FROM menu_item mi, course c, menu_item_has_ingredient item_ingredient, ingredient ing WHERE mi.course_id = c.course_id AND mi.item_id = item_ingredient.menu_item_id AND item_ingredient.ingredient_id = ing.ingredient_id GROUP BY mi.item_id ORDER BY c.priority ";
    const SELECT_MENU_HAS_ITEM = "SELECT item_id FROM menu_has_item WHERE menu_id = ?";
    const SELECT_ITEM_IN_MENU = "SELECT `menu_id`, `item_id` FROM `menu_has_item` WHERE `item_id` = ?";
    const SELECT_ITEM_PROPS = "SELECT c.course_name, c.priority, i.item_id, i.name FROM course c, menu_item i WHERE i.item_id = ? AND i.course_id = c.course_id";
    const INSERT = "INSERT INTO menu_item (course_id, name, image, price) VALUES (?, ?, ?, ?)";
    const SELECT_ID = "SELECT * FROM menu_item WHERE item_id = ?";
    const DELETE = "DELETE FROM menu_item WHERE item_id = ?";
    const UPDATE = "UPDATE menu_item SET course_id = ?, name = ?, image = ? WHERE name = ?";

    private $dbSource;

    function __construct() {
        try {
            $this->dbSource = DBConnect::getInstance();
        } catch (Exception $ex) {
            error_log("Error in DBCONNECT: " . $e->getMessage() . " ");
            die();
        }
    }
    
    public function findItemInMenu($menuItemId){
        return $this->dbSource->execution(self::SELECT_ITEM_IN_MENU, $array=[$menuItemId]);
    }
    
    public function create($entity) {
        
        $vector = [
            $entity->getCourseId(),
            $entity->getName(),
            $entity->getImage(),
            $entity->getPrice()
        ];

        return $this->dbSource->executeTransaction(self::INSERT, $vector);
    }

    public function delete($entity) {
        //:course_id,:meal_name,:meal_price,:meal_image
        $vector = [$entity->getItemId()];

        return $this->dbSource->execution(self::DELETE, $vector);
    }

    public function update($entity) {
        $this->menuItem = new MenuItemClass($entity->getItemId(), $entity->getCourseId(), $entity->getName(), $entity->getImage(), $entity->getPrice());
        //:course_id,:meal_name,:meal_price,:meal_image
        $vector = [ "itemId" => $entity->getItemId(),
        ];

        return $this->dbSource->executionUpdate(self::UPDATE, $vector);
    }

    public function findAllWithIngredients() {
        return $this->dbSource->execution(self::SELECT_ALL_WITH_INGREDIENTS, $vector = []);
    }
    
    public function findAll(){
        
    }
    
    public function findMenuHasItem($menuId){
        $array = [$menuId];
        return $this->dbSource->execution(self::SELECT_MENU_HAS_ITEM,$array);
    }
    
    public function findItemsProps($itemId){
        $array = [$itemId];
        return $this->dbSource->execution(self::SELECT_ITEM_PROPS,$array);
    }

}

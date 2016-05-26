<?php

require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Orders/OrderClass.php";

/**
 * Description of OrderADO
 *
 * @author Victor
 */
class OrderADO implements EntityInterfaceADO {

    //Queries
    const CHEF_AVAILABLE = "SELECT count(o.chef_id) num_orders, c.chef_id FROM orders o RIGHT OUTER JOIN chef c ON o.chef_id = c.chef_id AND o.status_id = 1 GROUP BY o.chef_id, c.chef_id ORDER BY num_orders ";
    const WAITER_AVAILABLE = "SELECT count(o.waiter_id) num_orders, w.waiter_id FROM orders o RIGHT OUTER JOIN waiter w ON o.chef_id = w.waiter_id AND o.status_id = 3 GROUP BY o.waiter_id, w.waiter_id ORDER BY num_orders";
    const INSERT_ORDER = "INSERT INTO `orders` (`status_id`, `table_id`, `chef_id`, `waiter_id`, `client_id`, `menu_id`, `order_date`, `total_price`) VALUES (?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP, ?)";
    const SELECT_ORDERS_CHEF = "SELECT m.name menu_name, m.image menu_image, m.price menu_price, o.*, mhi.*, GROUP_CONCAT(mi.name SEPARATOR ';') items_menu, GROUP_CONCAT(c.priority SEPARATOR ';') item_priority FROM orders o, menu m, menu_has_item mhi, menu_item mi, course c WHERE status_id = 1 and chef_id = ? AND o.menu_id = m.menu_id AND mhi.menu_id = o.menu_id AND mi.item_id = mhi.item_id AND mi.course_id = c.course_id GROUP BY o.order_id ORDER BY o.order_date ";
    const UPDATE_STATUS_ORDER = "UPDATE orders SET status_id = ? WHERE `order_id` = ? ";

    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function updateOrderStatus($orderId, $statusId) {
        return $this->dataSource->execution(self::UPDATE_STATUS_ORDER, $array = [$statusId, $orderId]);
    }

    public function findChefOrders($chefId) {
        return $this->dataSource->execution(self::SELECT_ORDERS_CHEF, $array = [$chefId]);
    }

    public function findChefDisponible() {
        return $this->dataSource->execution(self::CHEF_AVAILABLE, $array = []);
    }

    public function findWaiterAvailable() {
        return $this->dataSource->execution(self::WAITER_AVAILABLE, $array = []);
    }

    public function create($order) {
        //`status_id`, `table_id`, `chef_id`, `waiter_id`, `client_id`, `menu_id`, `order_date`, `total_price`
        $array = [$order->getStatusId(),
            $order->getTableId(),
            $order->getChefId(),
            $order->getWaiterId(),
            $order->getClientId(),
            $order->getMenuId(),
            $order->getTotalPrice()];

        return $this->dataSource->executeTransaction(self::INSERT_ORDER, $array);
    }

    public function delete($entity) {
        
    }

    public function findAll() {
        
    }

    public function update($entity) {
        
    }

//put your code here
}

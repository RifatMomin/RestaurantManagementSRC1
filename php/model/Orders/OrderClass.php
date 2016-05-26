<?php

/**
 * Description of OrderClass
 *
 * @author victor
 */
require_once "../model/EntityInterface.php";

class OrderClass {

    private $orderId;
    private $statusId;
    private $tableId;
    private $chefId;
    private $waiterId;
    private $clientId;
    private $date;
    private $totalPrice;

    function __construct($orderId, $statusId, $tableId, $chefId, $waiterId, $clientId, $date, $totalPrice) {
        $this->orderId = $orderId;
        $this->statusId = $statusId;
        $this->tableId = $tableId;
        $this->chefId = $chefId;
        $this->waiterId = $waiterId;
        $this->clientId = $clientId;
        $this->date = $date;
        $this->totalPrice = $totalPrice;
    }

    function getOrderId() {
        return $this->orderId;
    }

    function getStatusId() {
        return $this->statusId;
    }

    function getTableId() {
        return $this->tableId;
    }

    function getChefId() {
        return $this->chefId;
    }

    function getWaiterId() {
        return $this->waiterId;
    }

    function getClientId() {
        return $this->clientId;
    }

    function getDate() {
        return $this->date;
    }

    function getTotalPrice() {
        return $this->totalPrice;
    }

    function setOrderId($orderId) {
        $this->orderId = $orderId;
    }

    function setStatusId($statusId) {
        $this->statusId = $statusId;
    }

    function setTableId($tableId) {
        $this->tableId = $tableId;
    }

    function setChefId($chefId) {
        $this->chefId = $chefId;
    }

    function setWaiterId($waiterId) {
        $this->waiterId = $waiterId;
    }

    function setClientId($clientId) {
        $this->clientId = $clientId;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setTotalPrice($totalPrice) {
        $this->totalPrice = $totalPrice;
    }

    function getAll() {
        $data = [];

        $data['orderId'] = $this->getOrderId();
        $data['statusId'] = $this->getStatusId();
        $data['tableId'] = $this->getTableId();
        $data['chefId'] = $this->getChefId();
        $data['waiterId'] = $this->getWaiterId();
        $data['clientId'] = $this->getClientId();
        $data['date'] = $this->getDate();
        $data['totalPrice'] = $this->getTotalPrice();

        return $data;
    }

}

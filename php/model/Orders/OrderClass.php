<?php

/**
 * Description of OrderClass
 *
 * @author victor
 */

require_once "EntityInterface.php";

class OrderClass implements EntityInterface{

    private $orderId;
    private $status;
    private $table;
    private $chef;
    private $waiter;
    private $client;
    private $date;
    private $totalPrice;

    function __construct($orderId, $status, $table, $chef, $waiter, $client, $date, $totalPrice) {
        $this->orderId = $orderId;
        $this->status = $status;
        $this->table = $table;
        $this->chef = $chef;
        $this->waiter = $waiter;
        $this->client = $client;
        $this->date = $date;
        $this->totalPrice = $totalPrice;
    }

    function getOrderId() {
        return $this->orderId;
    }

    function getStatus() {
        return $this->status;
    }

    function getTable() {
        return $this->table;
    }

    function getChef() {
        return $this->chef;
    }

    function getWaiter() {
        return $this->waiter;
    }

    function getClient() {
        return $this->client;
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

    function setStatus($status) {
        $this->status = $status;
    }

    function setTable($table) {
        $this->table = $table;
    }

    function setChef($chef) {
        $this->chef = $chef;
    }

    function setWaiter($waiter) {
        $this->waiter = $waiter;
    }

    function setClient($client) {
        $this->client = $client;
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
        $data['status'] = $this->getStatus();
        $data['table'] = $this->getTable();
        $data['chef'] = $this->getChef();
        $data['waiter'] = $this->getWaiter();
        $data['client'] = $this->getClient();
        $data['date'] = $this->getDate();
        $data['totalPrice'] = $this->getTotalPrice();

        return $data;
    }

}

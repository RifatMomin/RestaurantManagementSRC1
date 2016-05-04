/**
 * @description This is the Order object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

OrderObj = function () {
    this.orderId = null;
    this.status = null;
    this.table = null;
    this.chef = null;
    this.waiter = null;
    this.client = null;
    this.date = null;
    this.totalPrice = null;

    this.construct = function(orderId,status,table,chef,waiter,client,date,totalPrice){
        this.setOrderId(orderId);
        this.setStatus(status);
        this.setTable(table);
        this.setChef(chef);
        this.setWaiter(waiter);
        this.setClient(client);
        this.setDate(date);
        this.setTotalPrice(totalPrice);
    };

    this.setOrderId = function (orderId) {
        this.orderId = orderId;
    }
    this.getOrderId = function () {
        return this.orderId;
    }
    this.setStatus = function (status) {
        this.status = status;
    }
    this.getStatus = function () {
        return this.status;
    }
    this.setTable = function (table) {
        this.table = table;
    }
    this.getTable = function () {
        return this.table;
    }
    this.setChef = function (chef) {
        this.chef = chef;
    }
    this.getChef = function () {
        return this.chef;
    }
    this.setWaiter = function (waiter) {
        this.waiter = waiter;
    }
    this.getWaiter = function () {
        return this.waiter;
    }
    this.setClient = function (client) {
        this.client = client;
    }
    this.getClient = function () {
        return this.client;
    }
    this.setDate = function (date) {
        this.date = date;
    }
    this.getDate = function () {
        return this.date;
    }
    this.setTotalPrice = function (totalPrice) {
        this.totalPrice = totalPrice;
    }
    this.getTotalPrice = function () {
        return this.totalPrice;
    }

};
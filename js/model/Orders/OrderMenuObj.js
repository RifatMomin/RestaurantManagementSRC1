/**
 * @description This is the Order Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

OrderMenuObj = function () {
    this.orderIdMenuId = null;
    this.orderId = null;
    this.mealId = null;

    this.construct = function (orderIdMenuId, orderId, mealId) {
        this.setOrderItemId(orderIdMenuId);
        this.setOrderId(orderId);
        this.setMealId(mealId);
    };


    this.setOrderItemId = function (orderIdMenuId) {
        this.orderIdMenuId = orderIdMenuId;
    }
    this.getOrderItemId = function () {
        return this.orderIdMenuId;
    }
    this.setOrderId = function (orderId) {
        this.orderId = orderId;
    }
    this.getOrderId = function () {
        return this.orderId;
    }
    this.setMealId = function (mealId) {
        this.mealId = mealId;
    }
    this.getMealId = function () {
        return this.mealId;
    }
};



/**
 * @description This is the Order Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

OrderMenuItemObj = function () {
    this.orderItemId = null;
    this.orderId = null;
    this.mealId = null;

    this.construct = function (orderItemId, orderId, mealId) {
        this.setOrderItemId(orderItemId);
        this.setOrderId(orderId);
        this.setMealId(mealId);
    };


    this.setOrderItemId = function (orderItemId) {
        this.orderItemId = orderItemId;
    }
    this.getOrderItemId = function () {
        return this.orderItemId;
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



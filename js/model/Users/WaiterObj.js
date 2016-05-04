/**
 * @description This is the waiter object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

WaiterObj = function () {
    this.waiter_id = null;

    this.construct = function(waiter_id){
        this.setWaiter_id(waiter_id);
    };

    this.setWaiter_id = function (waiter_id) {
        this.waiter_id = waiter_id;
    }
    this.getWaiter_id = function () {
        return this.waiter_id;
    }

};

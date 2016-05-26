/**
 * @description This is the waiter object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

ClientObj = function () {
    this.client_id = null;
    this.user_id = null;

    this.construct = function(client_id, user_id){
        this.setClient_id(client_id);
        this.setUserId(user_id);
    };

    this.setClient_id = function (client_id) {
        this.client_id = client_id;
    }
    this.getClient_id = function () {
        return this.client_id;
    }
    
    this.setUserId = function (user_id) {
        this.user_id = user_id;
    }
    this.getUserId = function () {
        return this.user_id;
    }

};

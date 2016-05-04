/**
 * @description This is the waiter object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

ClientObj = function () {
    this.client_id = null;

    this.construct = function(client_id){
        this.setClient_id(client_id);
    };

    this.setClient_id = function (client_id) {
        this.client_id = client_id;
    }
    this.getClient_id = function () {
        return this.client_id;
    }

};

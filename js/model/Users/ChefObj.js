/**
 * @description This is the chef object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

ChefObj = function () {
    this.chef_id = null;

    this.construct = function(chef_id){
        this.setWaiter_id(chef_id);
    };

    this.setChef_id = function (chef_id) {
        this.chef_id = chef_id;
    }
    this.getChef_id = function () {
        return this.chef_id;
    }

};

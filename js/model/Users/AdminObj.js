/**
 * @description This is the admin object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

AdminObj = function () {
    this.admin_id = null;

    this.construct = function(admin_id){
        this.setAdmin_id(admin_id);
    };

    this.setAdmin_id = function (admin_id) {
        this.admin_id = admin_id;
    }
    this.getAdmin_id = function () {
        return this.admin_id;
    }

};

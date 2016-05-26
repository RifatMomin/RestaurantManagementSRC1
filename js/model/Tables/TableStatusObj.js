/**
 * @description This is the Table Status object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

TableStatusObj = function () {
    
    this.table_status_id = null;
    this.name_status = null;

    this.construct = function(table_status_id, name_status){
        this.setTableStatusId(table_status_id);
        this.setNameStatus(name_status);
    };

    this.setTableStatusId = function (table_status_id){
        this.table_status_id = table_status_id;
    }
    
    this.setNameStatus = function (name_status){
        this.name_status = name_status;
    }
    
    this.getTableStatusId = function (){
        return this.table_status_id;
    }
    
    this.getNameStatus = function (){
        return this.name_status;
    }


};
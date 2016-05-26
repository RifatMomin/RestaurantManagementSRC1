/**
 * @description This is the Table object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */
TableObj = function () {
    this.table_id = null;
    this.table_status = null;
    this.table_type = null;
    this.table_location = null;
    this.capacity = null;
    this.active = null;

    this.construct = function(table_id, table_type, table_status, table_location, capacity, active){
        this.setTableId(table_id);
        this.setTableType(table_type);
        this.setTableStatus(table_status);
        this.setTableLocation(table_location);
        this.setCapacity(capacity);
        this.setActive(active);
    };

    this.setTableId = function (table_id) {
        this.table_id = table_id;
    }
    this.getTableId = function () {
        return this.table_id;
    }
    this.setTableStatus = function (table_status) {
        this.table_status = table_status;
    }
    this.getTableStatus = function () {
        return this.table_status;
    }
    this.setTableType = function (table_type) {
        this.table_type = table_type;
    }
    this.getTableType = function () {
        return this.table_type;
    }
    this.setTableLocation = function (table_location) {
        this.table_location = table_location;
    }
    this.getTableLocation = function () {
        return this.table_location;
    }
    this.setCapacity = function (capacity) {
        this.capacity = capacity;
    }
    this.getCapacity = function () {
        return this.capacity;
    }
    this.setActive = function(active){
        this.active = active;
    }
    this.getActive = function (){
        return this.active;
    }
    

};
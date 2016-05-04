/**
 * @description This is the Table object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

TableObj = function () {
    this.tableId = null;
    this.status = null;
    this.type = null;
    this.location = null;
    this.capacity = null;

    this.construct = function(tableId,status,type,location,capacity){
        this.setTableId(tableId);
        this.setStatus(status);
        this.setType(type);
        this.setLocation(location);
        this.setCapacity(capacity);
    };

    this.setTableId = function (tableId) {
        this.tableId = tableId;
    }
    this.getTableId = function () {
        return this.tableId;
    }
    this.setStatus = function (status) {
        this.status = status;
    }
    this.getStatus = function () {
        return this.status;
    }
    this.setType = function (type) {
        this.type = type;
    }
    this.getType = function () {
        return this.type;
    }
    this.setLocation = function (location) {
        this.location = location;
    }
    this.getLocation = function () {
        return this.location;
    }
    this.setCapacity = function (capacity) {
        this.capacity = capacity;
    }
    this.getCapacity = function () {
        return this.capacity;
    }
    

};
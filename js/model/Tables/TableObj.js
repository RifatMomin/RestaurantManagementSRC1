/**
 * @description This is the Table object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

TableObj = function () {
    this.tableId = null;
    this.tableStatus = null;
    this.tableType = null;
    this.tableLocation = null;
    this.capacity = null;

    this.construct = function(tableId, tableType, tableStatus, tableLocation, capacity){
        this.setTableId(tableId);
        this.setTableType(tableType);
        this.setTableStatus(tableStatus);
        this.setTableLocation(tableLocation);
        this.setCapacity(capacity);
    };

    this.setTableId = function (tableId) {
        this.tableId = tableId;
    }
    this.getTableId = function () {
        return this.tableId;
    }
    this.setTableStatus = function (tableStatus) {
        this.tableStatus = tableStatus;
    }
    this.getTableStatus = function () {
        return this.tableStatus;
    }
    this.setTableType = function (tableType) {
        this.tableType = tableType;
    }
    this.getTableType = function () {
        return this.tableType;
    }
    this.setTableLocation = function (tableLocation) {
        this.tableLocation = tableLocation;
    }
    this.getTableLocation = function () {
        return this.tableLocation;
    }
    this.setCapacity = function (capacity) {
        this.capacity = capacity;
    }
    this.getCapacity = function () {
        return this.capacity;
    }
    

};
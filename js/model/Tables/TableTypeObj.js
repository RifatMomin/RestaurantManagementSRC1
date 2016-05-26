/**
 * @description This is the Table Type object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

TableTypeObj = function () {
    
    this.type_id = null;
    this.name_type = null;

    this.construct = function(type_id, name_type){
        this.setTypeId(type_id);
        this.setNameType(name_type);
    };

    this.setTypeId = function (type_id) {
        this.type_id = type_id;
    }
    this.getTypeId = function () {
        return this.type_id;
    }
    this.setNameType = function (name_type) {
        this.name_type = name_type;
    }
    this.getNameType = function () {
        return this.name_type;
    }


};
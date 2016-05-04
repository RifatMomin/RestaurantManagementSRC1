/**
 * @description This is the Table Location object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

TableLocationObj = function () {
    this.id = null;
    this.name = null;

    this.construct = function(id,name){
        this.setId(id);
        this.setName(name);
    };

    this.setId = function (id) {
        this.id = id;
    }
    this.getId = function () {
        return this.id;
    }
    this.setName = function (name) {
        this.name = name;
    }
    this.getName = function () {
        return this.name;
    }


};
/**
 * @description This is the Course object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

CourseObj = function () {
    this.id = null;
    this.name = null;
    this.priority = null;

    this.construct = function(id,name, priority){
        this.setId(id);
        this.setName(name);
        this.setPriority(priority);
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
    this.setPriority= function (priority) {
        this.priority = priority;
    }
    this.getPriority = function () {
        return this.priority;
    }

};
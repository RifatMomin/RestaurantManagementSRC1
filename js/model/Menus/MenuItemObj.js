/**
 * @description This is the Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

MenuItemObj = function () {
    
    this.itemId = null;
    this.courseId = null;
    this.name = null;
    this.image = null;
    this.price = null;

    this.construct = function(itemId, courseId, name, image, price){
        this.setItemId(itemId);
        this.setCourseId(courseId);
        this.setName(name);
        this.setImage(image)
        this.setPrice(price);
    };

    this.setItemId = function (itemId) {
        this.itemId = itemId;
    }
    this.getItemId = function () {
        return this.itemId;
    }
    this.setCourseId = function (courseId) {
        this.courseId = courseId;
    }
    this.getCourseId = function () {
        return this.courseId;
    }
    this.setName = function (name) {
        this.name = name;
    }
    this.getName = function () {
        return this.name;
    }
    this.setImage = function (image) {
        this.image = image;
    }
    this.getImage = function () {
        return this.image;
    }
    this.getPrice= function () {
        return this.price;
    }
    this.setPrice = function (price) {
        this.price= price;
    }
    
    
};
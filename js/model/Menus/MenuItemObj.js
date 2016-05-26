/**
 * @description This is the Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

MenuItemObj = function () {
    
    this.itemId = 0;
    this.course = new CourseObj();
    this.name = "";
    this.image = "";
    this.price = 0;
    this.ingredients = [];

    this.construct = function(itemId, course, name, image, price){
        this.setItemId(itemId);
        this.setCourse(course);
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
    this.setCourse = function (course) {
        this.course = course;
    }
    this.getCourse = function () {
        return this.course;
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
    this.setIngredients = function(ingredients){
        this.ingredients=ingredients;
    };
    this.getIngredients = function(){
        return this.ingredients;
    };
};
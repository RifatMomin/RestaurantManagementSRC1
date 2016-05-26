/**
 * @description This is the Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

MenuObj = function () {

    this.menuId = null;
    this.name = null;
    this.image = null;
    this.price = null;
    this.description = null;
    this.personalized = null;
    this.active = 1;
    this.items = [];

    this.construct = function (menuId, name, image, price, description, personalized) {
        this.setName(name);
        this.setMenuId(menuId);
        this.setDescription(description);
        this.setPersonalized(personalized);
        this.setImage(image);
        this.setPrice(price);
    };
    
    this.setActive = function(active){
        this.active = active;
    };
    this.setName = function (name) {
        this.name = name;
    }
    this.getName = function () {
        return this.name;
    }
    this.setMenuId = function (menuId) {
        this.menuId = menuId;
    }
    this.getMenuId = function () {
        return this.menuId;
    }
    this.setDescription = function (description) {
        this.description = description;
    }
    this.getDescription = function () {
        return this.description;
    }
    this.setPersonalized = function (personalized) {
        this.personalized = personalized;
    }
    this.getPersonalized = function () {
        return this.personalized;
    }
    this.getImage = function () {
        return this.image;
    }
    this.setImage = function (image) {
        this.image = image;
    }
    this.getPrice = function () {
        return this.price;
    }
    this.setPrice = function (price) {
        this.price = price;
    }
    this.setItems = function (items) {
        this.items = items;
    }
    this.getItems = function () {
        return this.items;
    }
};
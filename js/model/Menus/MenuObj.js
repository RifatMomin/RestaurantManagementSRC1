/**
 * @description This is the Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

MenuObj = function () {
    
    this.menuId = null;
    this.image = null;
    this.price = null;

    this.construct = function(menuId, first, second, dessert, drink, image, price){
        this.setMenuId(menuId);
        this.setFirst(first);
        this.setSecond(second);
        this.setDessert(dessert);
        this.setDrink(drink);
        this.setImage(image);
        this.setPrice(price);
    };

    this.setMenuId = function (menuId) {
        this.menuId = menuId;
    }
    this.getMenuId = function () {
        return this.menuId;
    }
    this.setFirst = function (first) {
        this.first = first;
    }
    this.getFirst = function () {
        return this.first;
    }
    this.setSecond = function (second) {
        this.second = second;
    }
    this.getSecond = function () {
        return this.second;
    }
    this.getDessert= function () {
        return this.dessert;
    }
    this.setDessert = function (dessert) {
        this.dessert = dessert;
    }
    this.getDrink = function () {
        return this.drink;
    }
    this.setDrink = function (drink) {
        this.drink = drink;
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
    
};
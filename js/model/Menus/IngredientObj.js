/**
 * @description This is the Ingredient object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

IngredientObj = function () {
    this.ingredientId = null;
    this.name = null;
    this.price = null;

    this.construct = function(ingredientId,name,price){
        this.setIngredientId(ingredientId);
        this.setName(name);
        this.setPrice(price);
    };

    this.setIngredientId = function (ingredientId) {
        this.ingredientId = ingredientId;
    }
    this.getIngredientId = function () {
        return this.ingredientId;
    }
    this.setName = function (name) {
        this.name = name;
    }
    this.getName = function () {
        return this.name;
    }
    this.setPrice = function (price) {
        this.price = price;
    }
    this.getPrice = function () {
        return this.price;
    }

};

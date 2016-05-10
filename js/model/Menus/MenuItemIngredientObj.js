/**
 * @description MenuItemIngredientObj Object
 * @author Rifat Momin
 * @date 2016/05/10
 * @version 1
 */

MenuItemIngredientObj = function () {

    this.menuItemIngredientId = null;
    this.itemId = null;
    this.ingredientId = null;
    this.quantity = null;


    this.construct = function(menuItemIngredientId, itemId, ingredientId, quantity){
        this.setMenuItemIngredientId(menuItemIngredientId);
        this.setItemId(itemId);
        this.setIngredientId(ingredientId);
        this.setQuantity(quantity);
    };

    this.setMenuItemIngredientId = function (menuItemIngredientId) {
        this.menuItemIngredientId = menuItemIngredientId;
    }
    this.getMenuItemIngredientId = function () {
        return this.menuItemIngredientId;
    }
    this.setItemId = function (itemId) {
        this.itemId = itemId;
    }
    this.getItemId = function () {
        return this.itemId;
    }
    this.setIngredientId = function (ingredientId) {
        this.ingredientId = ingredientId;
    }
    this.getIngredientId = function () {
        return this.ingredientId;
    }
    this.setQuantity = function (quantity) {
        this.quantity = quantity;
    }
    this.getQuantity = function () {
        return this.quantity;
    }
    
    
};
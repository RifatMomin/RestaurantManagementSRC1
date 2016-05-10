/**
 * @description This is the Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

MenuMenuItemObj= function () {
    
    this.menuMenuItemId= null;
    this.menuId = null;
    this.itemId = null;
   
    this.construct = function(menuMenuItemId, menuId, itemId){
        this.setMenuMenuItemId(menuMenuItemId);
        this.setMenuId(menuId);
        this.setItemId(itemId);
        
    };

    this.setMenuMenuItemId= function (menuMenuItemId) {
        this.menuMenuItemId = menuMenuItemId;
    }
    this.getMenuMenuItemId = function () {
        return this.menuMenuItemId;
    }
    this.setMenuId = function (menuId) {
        this.menuId = menuId;
    }
    this.getMenuId = function () {
        return this.menuId;
    }
    this.setItemId = function (itemId) {
        this.itemId = itemId;
    }
};
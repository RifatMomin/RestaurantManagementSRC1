/**
 * @description This is the chef object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

ChefObj = function () {
    this.userId = null;
    this.chefId = null;
    this.chefLevel = null;

    this.construct = function(userId, chefId, chefLevel){
        this.setUserId(userId);
        this.setWaiterId(chefId);
        this.setChefLevel(chefLevel);
    };
    
    this.setUserId = function(user_id){
        this.userId = userId;
    }

    this.setChefId = function (chefId) {
        this.chefId = chefId;
    }
    this.getChefId = function () {
        return this.chefId;
    }

};

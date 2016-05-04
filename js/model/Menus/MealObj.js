/**
 * @description This is the Menu Item object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

MealObj = function () {
    this.mealId = null;
    this.course = null;
    this.name = null;
    this.price = null;

    this.construct = function(mealId,course,name,price){
        this.setMealId(mealId);
        this.setCourse(course);
        this.setName(name);
        this.setPrice(price);
    };

    this.setMealId = function (mealId) {
        this.mealId = mealId;
    }
    this.getMealId = function () {
        return this.mealId;
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
    this.setPrice = function (price) {
        this.price = price;
    }
    this.getPrice = function () {
        return this.price;
    }

};
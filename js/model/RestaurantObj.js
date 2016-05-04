/**
 * @description This is the Restaurant object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

RestaurantObj = function () {
    this.id_restaurant = null;
    this.CIF = null;
    this.name = null;
    this.address = null;
    this.city = null;
    this.zipCode = null;
    this.phone1 = null;
    this.phone2 = null;
    this.email = null;
    this.description = null;

    this.construct = function(idRestaurant,CIF,name,address,city,zipCode,phone1, phone2,email,description){
        this.setId_restaurant(idRestaurant);
        this.setCIF(CIF);
        this.setName(name);
        this.setAddress(address);
        this.setCity(city);
        this.setZipCode(zipCode);
        this.setPhone1(phone1);
        this.setPhone2(phone2);
        this.setEmail(email);
        this.setDescription(description);
    };

    this.setId_restaurant = function (id_restaurant) {
        this.id_restaurant = id_restaurant;
    }
    this.getId_restaurant = function () {
        return this.id_restaurant;
    }
    this.setCIF = function (CIF) {
        this.CIF = CIF;
    }
    this.getCIF = function () {
        return this.CIF;
    }
    this.setName = function (name) {
        this.name = name;
    }
    this.getName = function () {
        return this.name;
    }
    this.setAddress = function (address) {
        this.address = address;
    }
    this.getAddress = function () {
        return this.address;
    }
    this.setCity = function (city) {
        this.city = city;
    }
    this.getCity = function () {
        return this.city;
    }
    this.setZipCode = function (zipCode) {
        this.zipCode = zipCode;
    }
    this.getZipCode = function () {
        return this.zipCode;
    }
    this.setPhone1 = function (phone1) {
        this.phone1 = phone1;
    }
    this.getPhone1 = function () {
        return this.phone1;
    }
    this.setPhone2 = function (phone2) {
        this.phone2 = phone2;
    }
    this.getPhone2 = function () {
        return this.phone2;
    }
    this.setEmail = function (email) {
        this.email = email;
    }
    this.getEmail = function () {
        return this.email;
    }
    this.setDescription = function (description) {
        this.description = description;
    }
    this.getDescription = function () {
        return this.description;
    }

};



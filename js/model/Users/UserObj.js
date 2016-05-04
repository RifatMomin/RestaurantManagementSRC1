/**
 * @description This is the user object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */

UserObj = function () {
    this.userId = null;
    this.username = null;
    this.password = null;
    this.name = null;
    this.surname = null;
    this.email = null;
    this.phone = null;
    this.address = null;
    this.city = null;
    this.zip_code = null;
    this.image = null;
    this.register_date = null;
    this.role=null;


    this.construct = function (userId, username, password, name, surname, email, phone, address, city, zipCode, image, registerDate, role) {
        this.setUserId(userId);
        this.setUsername(username);
        this.setPassword(password);
        this.setName(name);
        this.setSurname(surname);
        this.setEmail(email);
        this.setPhone(phone);
        this.setAddress(address);
        this.setCity(city);
        this.setZip_code(zipCode);
        this.setImage(image);
        this.setRegister_date(registerDate);
        this.role(role);
    };

    this.setUserId = function (userId) {
        this.userId = userId;
    }
    this.getUserId = function () {
        return this.userId;
    }
    this.setUsername = function (username) {
        this.username = username;
    }
    this.getUsername = function () {
        return this.username;
    }
    this.setPassword = function (password) {
        this.password = password;
    }
    this.getPassword = function () {
        return this.password;
    }
    this.setName = function (name) {
        this.name = name;
    }
    this.getName = function () {
        return this.name;
    }
    this.setSurname = function (surname) {
        this.surname = surname;
    }
    this.getSurname = function () {
        return this.surname;
    }
    this.setEmail = function (email) {
        this.email = email;
    }
    this.getEmail = function () {
        return this.email;
    }
    this.setPhone = function (phone) {
        this.phone = phone;
    }
    this.getPhone = function () {
        return this.phone;
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
    this.setZip_code = function (zip_code) {
        this.zip_code = zip_code;
    }
    this.getZip_code = function () {
        return this.zip_code;
    }
    this.setImage = function (image) {
        this.image = image;
    }
    this.getImage = function () {
        return this.image;
    }
    this.setRegister_date = function (register_date) {
        this.register_date = register_date;
    }
    this.getRegister_date = function () {
        return this.register_date;
    }
    this.setRole = function (role) {
        this.role = role;
    }
    this.getRole = function () {
        return this.role;
    }
    
    /*
    * @name: toString()
    * @author: Rifat/Victor
    * @version: 3.1
    * @description: convert object to string
    * @date: 04/03/2015
   */
    this.toString = function ()
    {
	var userString ="userId="+this.getUserId()+" username="+this.getName()+" password="+this.getPassword();
	userString +=" name="+this.getName()+" surname="+this.getSurname()+" email="+this.getEmail()+" phone="+this.getPhone();
	userString +=" address="+this.getAddress()+" city="+this.getCity()+" zip code="+this.getZip_code()()+" image="+this.getImage()+" register date="+this.getRegister_date()+" role="+this.getRole()();
	
	return userString;		
    }




};


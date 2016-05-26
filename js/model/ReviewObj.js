/**
 * @description This is the Review object
 * @author Victor Moreno Garcia
 * @date 2016/05/02
 * @version 1
 */


ReviewObj = function () {
    this.idReview = null;
    this.clientId = null;
    this.restaurantId = null;
    this.foodQuality = null;
    this.menuVariety = null;
    this.customerTreatment = null;
    this.cleaniless = null;
    this.pricing = null;
    this.location = null;
    this.waitingTime = null;
    this.observations = null;
    this.dateReview = null;

    this.construct = function (idReview, clientId, restaurantId, foodQuality, menuVariety, customerTreatment, cleaniless, pricing, location, waitingTime, observations, dateReview) {
        setIdReview(idReview);
        setClientId(clientId);
        setRestaurantId(restaurantId);
        setFoodQuality(foodQuality);
        setMenuVariety(menuVariety);
        setCustomerTreatment(customerTreatment);
        setCleaniless(cleaniless);
        setPricing(pricing);
        setLocation(location);
        setWaitingTime(waitingTime);
        setObservations(observations);
        setDate(dateReview);
    };

    this.setIdReview = function (idReview) {
        this.idReview = idReview;
    }
    this.getIdReview = function () {
        return this.idReview;
    }
    this.setClientId = function (clientId){
        this.clientId = clientId;
    }
    this.getClientId = function (){
        return this.clientId;
    }
    this.setRestaurantId = function (restaurantId){
        this.restaurantId = restaurantId;
    }
    this.getRestaurantId = function (){
        return this.restaurantId;
    }
    this.setFoodQuality = function (foodQuality) {
        this.foodQuality = foodQuality;
    }
    this.getFoodQuality = function () {
        return this.foodQuality;
    }
    this.setMenuVariety = function (menuVariety) {
        this.menuVariety = menuVariety;
    }
    this.getMenuVariety = function () {
        return this.menuVariety;
    }
    this.setCustomerTreatment = function (customerTreatment) {
        this.customerTreatment = customerTreatment;
    }
    this.getCustomerTreatment = function () {
        return this.customerTreatment;
    }
    this.setCleaniless = function (cleaniless) {
        this.cleaniless = cleaniless;
    }
    this.getCleaniless = function () {
        return this.cleaniless;
    }
    this.setPricing = function (pricing) {
        this.pricing = pricing;
    }
    this.getPricing = function () {
        return this.pricing;
    }
    this.setLocation = function (location) {
        this.location = location;
    }
    this.getLocation = function () {
        return this.location;
    }
    this.setWaitingTime = function (waitingTime) {
        this.waitingTime = waitingTime;
    }
    this.getWaitingTime = function () {
        return this.waitingTime;
    }
    this.setObservations = function (observations) {
        this.observations = observations;
    }
    this.getObservations = function () {
        return this.observations;
    }
    this.setDate = function (date) {
        this.dateReview = date;
    }
    this.getDate = function () {
        return this.dateReview;
    }
};  
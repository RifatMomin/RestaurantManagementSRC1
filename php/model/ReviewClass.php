<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReviewClass
 *
 * @author Alumne
 */
class ReviewClass {

    //attributes
    private $idReview;
    private $clientId;
    private $restaurantId;
    private $foodQuality;
    private $menuVariety;
    private $customerTreatment;
    private $cleanliness;
    private $pricing;
    private $location;
    private $waitingTime;
    private $observations;
    private $dateReview;

    function __construct($idReview, $clientId, $restaurantId, $foodQuality, $menuVariety, $customerTreatment, $cleanliness, $pricing, $location, $waitingTime, $observations, $dateReview) {
        $this->idReview = $idReview;
        $this->clientId = $clientId;
        $this->restaurantId = $restaurantId;
        $this->foodQuality = $foodQuality;
        $this->menuVariety = $menuVariety;
        $this->customerTreatment = $customerTreatment;
        $this->cleanliness = $cleanliness;
        $this->pricing = $pricing;
        $this->location = $location;
        $this->waitingTime = $waitingTime;
        $this->observations = $observations;
        $this->dateReview = $dateReview;
    }

    public function getIdReview() {
        return $this->idReview;
    }
    
    public function getClientId(){
        return $this->clientId;
    }
    public function getRestaurantId(){
        return $this->restaurantId;
    }
    
    public function getFoodQuality() {
        return $this->foodQuality;
    }

    public function getMenuVariety() {
        return $this->menuVariety;
    }

    public function getCustomerTreatment() {
        return $this->customerTreatment;
    }

    public function getCleanliness() {
        return $this->cleanliness;
    }

    public function getPricing() {
        return $this->pricing;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getWaitingTime() {
        return $this->waitingTime;
    }

    public function getObservations() {
        return $this->observations;
    }

    public function getDate() {
        return $this->dateReview;
    }

    public function setIdReview($idReview) {
        $this->idReview = $idReview;
    }

    public function setFoodQuality($foodQuality) {
        $this->foodQuality = $foodQuality;
    }

    public function setMenuVariety($menuVariety) {
        $this->menuVariety = $menuVariety;
    }

    public function setCustomerTreatment($customerTreatment) {
        $this->customerTreatment = $customerTreatment;
    }

    public function setCleanliness($cleanliness) {
        $this->cleanliness = $cleanliness;
    }

    public function setPricing($pricing) {
        $this->pricing = $pricing;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setWaitingTime($waitingTime) {
        $this->waitingTime = $waitingTime;
    }

    public function setObservations($observations) {
        $this->observations = $observations;
    }

    public function setDate($date) {
        $this->dateReview = $dateReview;
    }
    public function setClientId(){
        $this->clientId = $clientId;
    }
    public function setRestaurantId(){
        $this->restaurantId = $restaurantId;
    }
    
    public function getAll() {
        $data = array();
        $data["idReview"] = $this->idReview;
        $data["clientId"] = $this->clientId;
        $data["restaurantId"] = $this->restaurantId;
        $data["foodQuality"] = $this->foodQuality;
        $data["menuVariety"] = $this->menuVariety;
        $data["customerTreatment"] = $this->customerTreatment;
        $data["cleanliness"] = $this->cleanliness;
        $data["pricing"] = $this->pricing;
        $data["location"] = $this->location;
        $data["waitingTime"] = $this->waitingTime;
        $data["observations"] = $this->observations;
        $data["dateReview"] = $this->dateReview;
        
        return $data;
    }
    
}

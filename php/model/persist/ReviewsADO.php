<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/ReviewClass.php";

class ReviewADO implements EntityInterfaceADO {
    //Queries
    const SELECT_ALL_REVIEWS = "SELECT r.*, u.user_name, u.surname FROM REVIEWS r, users u WHERE r.client_id = u.user_id";
    const INSERT_REVIEW = "INSERT INTO reviews(client_id, restaurant_id, food_quality, menu_variety, customer_treatment, cleaniless, pricing, local_location, waiting_time, observations) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($review) {
        
        $array = [
            $review->getClientId(),
            $review->getRestaurantId(),
            $review->getFoodQuality(),
            $review->getMenuVariety(),
            $review->getCustomerTreatment(),
            $review->getCleanliness(),
            $review->getPricing(),
            $review->getLocation(),
            $review->getWaitingTime(),
            $review->getObservations()
            
        ];
        
        return $this->dataSource->executionInsert(self::INSERT_REVIEW,$array=[]);
           
    }

    public function delete($entity) {
        
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_REVIEWS,$array=[]);
    }

    public function update($entity) {
        
    }

}

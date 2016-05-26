<?php
session_start();

require_once "./TableController.php";
require_once "./UserControllerClass.php";
require_once "./FileControllerClass.php";
require_once "./RestaurantInfoControllerClass.php";
require_once "./OrderController.php";
require_once "./MenuControllerClass.php";
require_once "./ReviewsController.php";
require_once "./CourseController.php";
require_once "./IngredientsController.php";
require_once "../model/Users/UserClass.php";


$outPutData = array();

if (isset($_REQUEST['controllerType'])) {
    $action = (int) $_REQUEST['controllerType'];
    switch ($action) {
        case 0:
            $userController = new UserController($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $userController->doAction();
            break;
        case 1:
            $orderController = new OrderControllerClass($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $orderController->doAction();
            break;
        case 2: 
            $restController = new RestaurantInfoController($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $restController->doAction();
            break;
        case 3:
            $menuController = new MenuControllerClass($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $menuController->doAction();
            break;
        case 4:
            $reviewController = new ReviewsController($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $reviewController->doAction();
            break;
        case 5:
            $ingredientController = new IngredientsController($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $ingredientController->doAction();
            break;
        case 6:
            $courseController = new CourseController($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $courseController->doAction();
            break;
        case 7:
            $tableController = new TableController($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $tableController->doAction();
            break;
        case 9:
            $fileController = new FileControllerClass($_REQUEST['action'], $_REQUEST['JSONData']);
            $outPutData = $fileController->doAction();
            break;
        default:
            $errors = array();
            $outPutData[0] = false;
            $errors[] = "Sorry, there has been an error. Try later";
            $outPutData[] = $errors;
            error_log("MainControllerClass: action not correct, value: " . $_REQUEST['controllerType']);
            break;
    }
} else {
    $errors = array();
    $outPutData[0] = false;
    $errors[] = "Sorry, there has been an error. Try later";
    error_log("MainControllerClass: action does not exist");
    $outPutData[] = $errors;
}

echo json_encode($outPutData);


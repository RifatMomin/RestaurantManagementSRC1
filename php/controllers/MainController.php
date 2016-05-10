<?php
session_start();

require_once "./UserControllerClass.php";
require_once "./FileControllerClass.php";
require_once "./RestaurantInfoControllerClass.php";
require_once "./MenuControllerClass.php";
//require_once "./OrderControllerClass.php";
//require_once "./TableControllerClass.php";
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


<?php

require_once "./UserControllerClass.php";
require_once "./FileControllerClass.php";
require_once "./RestaurantInfoControllerClass.php";
require_once "./MenuControllerClass.php";
//require_once "./OrderControllerClass.php";
//require_once "./TableControllerClass.php";

function is_session_started() {
    if (php_sapi_name() !== 'cli') {
        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

if (is_session_started() === FALSE) {
    session_start();
}


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


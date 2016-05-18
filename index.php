<!DOCTYPE html>
<?php
session_start();


if (isset($_SESSION['connectedUser'])) {
    header("Location: main.php");
}
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html ng-app="mainRestaurantApp">
    <head>
        <title>Restaurant Management</title>
        <link rel="icon" href="images/LOGO-PROJECT.png" type="image/png"/>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="cache-control" content="no-cache" >
        <meta http-equiv="pragma" content="no-cache" >

        <!--Bootstrap CSS-->
        <link href="css/bootstrap-3.3.6-dist-pers/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <link href="css/index.css" rel="stylesheet" type="text/css"/>

        <!--AngularJS and jQUeryJS-->
        <script src="js/frameworks/jquery-ui-1.11.4/external/jquery/jquery.js" type="text/javascript"></script>
        <script src="js/frameworks/jquery-ui-1.11.4/jquery-ui.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular.min.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/dirPagination.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular-file-upload.js" type="text/javascript"></script>
        <script src="css/bootstrap-3.3.6-dist-pers/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/frameworks/geoapi.es-js-master/GeoAPI.js" type="text/javascript"></script>

        <!--Library to SHA1 CRYOPT-->
        <script src="js/frameworks/cryptoJS/components/core-min.js" type="text/javascript"></script>
        <script src="js/frameworks/cryptoJS/components/sha1-min.js" type="text/javascript"></script>

        <!--Model-->
        <script src="js/model/Users/UserObj.js" type="text/javascript"></script>
        <script src="js/model/RestaurantObj.js" type="text/javascript"></script>
        <script src="js/model/Menus/MenuItemObj.js" type="text/javascript"></script>

<!--        <script src="http://crypto-js.googlecode.com/svn/tags/3.0.2/build/rollups/aes.js"></script>-->

        <!-- Index Control-->
        <script src="js/control/generalFunctions.js" type="text/javascript"></script>
        <script src="js/control/index.js" type="text/javascript"></script>
    </head>
    <body data-spy="scroll" data-target=".navbar"  ng-controller="mainAppController as mainCtrl" ng-init="getRestaurantInfo();getMenus();getReviews();loadProvinces()">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img class="img-thumbnail" src="images/LOGO-PROJECT.png" alt="" width="50" height="50"/>
                    </a>
                    <a class="navbar-brand">{{restaurantInfo.name}}</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="#menus">Menus</a></li>
                        <li><a href="#reviews">Reviews</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" data-toggle="modal" data-target="#signUpModal" ng-click="reloadRegister()"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#loginModal" ng-click="reloadLogin()"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="wrap">
            <div class="container container-index">
                    <menus-template></menus-template>
                
                    <reviews-template></reviews-template>
                    
                    <contact-template></contact-template>
                    
                    <retrieve-template ng-show="userAction = 1"></retrieve-template>                               
            </div>  
        </div>


    <login-template></login-template>


    <register-template></register-template>

    <error-message></error-message>
    <success-message></success-message>

    <footer-template></footer-template>
</body>
</html>

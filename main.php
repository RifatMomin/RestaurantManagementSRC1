<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION['connectedUser'])) {
    header("Location: ../RestaurantManagementSRC1");
}
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html ng-app="restaurantApp">
    <head>
        <meta charset="UTF-8">
        <title>{{theRestaurant.name}}</title>
        <link rel="icon" href="images/LOGO-PROJECT.png" type="image/png"/>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--Bootstrap CSS-->
        <link href="css/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <link href="css/index.css" rel="stylesheet" type="text/css"/>


        <!--AngularJS and jQUeryJS-->
        <script src="js/frameworks/jquery-ui-1.11.4/external/jquery/jquery.js" type="text/javascript"></script>
        <script src="js/frameworks/jquery-ui-1.11.4/jquery-ui.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular.min.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/dirPagination.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular-file-upload.js" type="text/javascript"></script>
        <script src="css/bootstrap-3.3.6-dist/js/bootstrap.min.js" type="text/javascript"></script>

        <!--Library to MD5 CRYOPT-->
        <script src="js/frameworks/cryptoJS/components/core-min.js" type="text/javascript"></script>
        <script src="js/frameworks/cryptoJS/components/md5.js" type="text/javascript"></script>

        <!--Model and Control-->
        <script src="js/model/RestaurantObj.js" type="text/javascript"></script>
        <script src="js/model/Users/UserObj.js" type="text/javascript"></script>
        <script src="js/control/generalFunctions.js" type="text/javascript"></script>
        <script src="js/control/main.js" type="text/javascript"></script>
    </head>
    <body ng-controller="restaurantController as restCtrl" ng-init="checkUserType();getUserInfo();getRestaurantInfo()">

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
                    <a class="navbar-brand">{{theRestaurant.name}}</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Menus</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" ng-click="action = 5"><span class="glyphicon glyphicon-user"></span>{{userLoggedIn.username}}</a></li>

                        <li><a href="#" ng-click="logOut()"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!--Charge here the different tempates, depending on the userType-->
        <div class="container">    
            <template-modify-user-data ng-show="action == 5"></template-modify-user-data>
        </div>



    <footer-template></footer-template>
</body>
</html>

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
        <title>Restaurant</title>
        <link rel="icon" href="images/LOGO-PROJECT.png" type="image/png"/>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="cache-control" content="no-cache" >
        <meta http-equiv="pragma" content="no-cache" >

        <!--Bootstrap CSS-->
        <link href="css/bootstrap-3.3.6-dist-pers/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        
        <link href="css/index.css" rel="stylesheet" type="text/css"/>


        <!--AngularJS and jQueryJS, and others-->
        <script src="js/frameworks/jquery-ui-1.11.4/external/jquery/jquery.js" type="text/javascript"></script>
        <script src="js/frameworks/jquery-ui-1.11.4/jquery-ui.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular.min.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/dirPagination.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular-file-upload.js" type="text/javascript"></script>
        <script src="css/bootstrap-3.3.6-dist-pers/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/ng-currency.js" type="text/javascript"></script>
        <script src="css/bootstrap-switch/js/bootstrap-switch.js" type="text/javascript"></script>
        
        <!--Library to SHA1 CRYOPT-->
        <script src="js/frameworks/cryptoJS/components/core-min.js" type="text/javascript"></script>
        <script src="js/frameworks/cryptoJS/components/sha1-min.js" type="text/javascript"></script>

        <script src="js/frameworks/geoapi.es-js-master/GeoAPI.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular-media-preview-master/src/angular-media-preview.module.js" type="text/javascript"></script>

        <!--Model and Control-->
        <script src="js/model/Orders/OrderObj.js" type="text/javascript"></script>
        <script src="js/model/Tables/TableTypeObj.js" type="text/javascript"></script>
        <script src="js/model/Tables/TableStatusObj.js" type="text/javascript"></script>
        <script src="js/model/Tables/TableLocationObj.js" type="text/javascript"></script>
        <script src="js/model/Tables/TableObj.js" type="text/javascript"></script>
        <script src="js/model/Menus/CourseObj.js" type="text/javascript"></script>
        <script src="js/model/Menus/MenuItemObj.js" type="text/javascript"></script>
        <script src="js/model/Menus/IngredientObj.js" type="text/javascript"></script>
        <script src="js/model/Menus/MenuObj.js" type="text/javascript"></script>
        <script src="js/model/RestaurantObj.js" type="text/javascript"></script>
        <script src="js/model/Users/UserObj.js" type="text/javascript"></script>
        <script src="js/control/generalFunctions.js" type="text/javascript"></script>
        <script src="js/control/main.js" type="text/javascript"></script>
    </head>
    <body ng-controller="restaurantController as restCtrl" ng-init="checkUserType(); getUserInfo(); getRestaurantInfo()">
        <!--Admin Template-->
        <admin-template ng-controller="adminController as adminCtrl" ng-if="rolePage == 3"></admin-template>  
        
        
        <!--Chef Template-->
        <chef-template ng-controller="chefController as chefCtrl" ng-if="rolePage == 1"></chef-template>
        
        
        <!--Waiter Template-->
        
        
        <!--Customer Template-->
        <customer-template ng-controller="customerController as customerCtrl" ng-if="rolePage == 0"></customer-template>
        
        
        
        
        <!--
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
                    <a class="navbar-brand">{{restaurantInfo.name}} {{roleName}}</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <customer-nav ng-if='rolePage == 0'></customer-nav>     
                    <chef-nav ng-if='rolePage == 1'></chef-nav>
                    <waiter-nav ng-if='rolePage == 2'></waiter-nav>
                    <admin-nav ng-if='rolePage == 3'></admin-nav>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" ng-click="action = 5; openModalData()" data-toggle="popover"><span class="glyphicon glyphicon-user"></span>{{userLoggedIn.username}}</a></li>
                        <li><a href="#" ng-click="logOut()"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="wrap">
        <div class="container">    
                    
            
            
                      
        </div>

            
        </div>-->
        
    <template-modify-user-data></template-modify-user-data>  
    <error-message></error-message>
    <success-message></success-message>


    <footer-template></footer-template>
</body>
</html>

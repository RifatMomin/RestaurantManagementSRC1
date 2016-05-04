<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION['connectedUser'])) {
    header("Location: index.php");
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
        <title></title>
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
        
        <script src="js/control/main.js" type="text/javascript"></script>
    </head>
    <body ng-controller="mainController as mainCtrl">
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
                    <a class="navbar-brand">"Restaurant Name"</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Menus</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" data-toggle="modal" data-target="#signUpModal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="#" ng-click="logOut()"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <footer class="navbar navbar-default navbar-fixed-bottom">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand footer-brand" href="#">Created by Rifat Momin and Victor Moreno</a>
                </div>
            </div>
        </footer>
        <div class="container">            
            <h2>Main</h2>
        </div>



        <?php
        // put your code here
        ?>
    </body>
</html>

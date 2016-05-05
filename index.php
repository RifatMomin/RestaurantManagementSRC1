<!DOCTYPE html>
<?php
session_start();


if (isset($_SESSION['connectedUser'])) {
    header("Location: main.php");
} else {
    echo "No hay user";
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
        <link href="css/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <link href="css/index.css" rel="stylesheet" type="text/css"/>


        <!--AngularJS and jQUeryJS-->
        <script src="js/frameworks/jquery-ui-1.11.4/external/jquery/jquery.js" type="text/javascript"></script>
        <script src="js/frameworks/jquery-ui-1.11.4/jquery-ui.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular.min.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/dirPagination.js" type="text/javascript"></script>
        <script src="js/frameworks/angular/angular-file-upload.js" type="text/javascript"></script>
        <script src="css/bootstrap-3.3.6-dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/frameworks/geoapi.es-js-master/GeoAPI.js" type="text/javascript"></script>

        <!--Library to MD5 CRYOPT-->
        <script src="js/frameworks/cryptoJS/components/core-min.js" type="text/javascript"></script>
        <script src="js/frameworks/cryptoJS/components/md5.js" type="text/javascript"></script>

        <!--Model-->
        <script src="js/model/Users/UserObj.js" type="text/javascript"></script>


        <!-- Index Control-->
        <script src="js/control/generalFunctions.js" type="text/javascript"></script>
        <script src="js/control/index.js" type="text/javascript"></script>
    </head>
    <body ng-controller="sessionController as sessionCtrl" ng-init="loadProvinces()">
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
                        <li><a href="#" data-toggle="modal" data-target="#loginModal" ><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <menus-template></menus-template>
            <contact-template></contact-template>
        </div>    

        <footer class="navbar navbar-default navbar-fixed-bottom">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand footer-brand" href="#">Created by Rifat Momin and Victor Moreno</a>
                </div>
            </div>
        </footer>

        <!-- Modal -->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modalLogin">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="modalLogin">Login</h4>
                    </div>
                    <div class="modal-body">
                        <form name="loginForm" ng-submit="connection()" novalidate>                            
                            <div class="col-lg-6 col-md-6 col-xs-12 center-block" ng-class="{'has-error': loginForm.username.$invalid }">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" ng-keydown="showInfoForm()" ng-model="user.username"  required/>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" ng-model="user.password" required/>
                                </div>
                                <a href="#">Lost Your Password? Retrieve it here.</a>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" ng-disabled="loginForm.$invalid">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="modalSignUp">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-center" id="modalSignUp">Sign Up</h4>
                    </div>

                    <div class="modal-body">
                        <form name="registerForm" novalidate ng-submit="register()" class="row">
                            <div class="col-md-6">
                                <div class="form-group" ng-class="{'has-error': registerForm.registerUsername.$invalid, 'has-success':registerForm.registerUsername.$valid}">
                                    <label>Username *</label>
                                    <input type="text" class="form-control" ng-model="registerUser.username" name="registerUsername"  required/>
                                </div>

                                <div class="form-group" ng-class="{'has-error': registerForm.registerPassword.$invalid, 'has-success':registerForm.registerPassword.$valid}">
                                    <label>Password *</label>
                                    <input type="password" class="form-control" ng-model="registerUser.password" name="registerPassword" required/>                                    
                                </div>

                                <div class="form-group" ng-class="{'has-error': registerForm.repeatPassword.$invalid, 'has-success':registerForm.repeatPassword.$valid}">
                                    <label>Repeat password *</label>
                                    <input type="password" class="form-control" name="repeatPassword" required/>
                                </div>

                                <div class="form-group" ng-class="{'has-error': registerForm.registerName.$invalid, 'has-success':registerForm.registerName.$valid}">
                                    <label>Name *</label>
                                    <input type="text" class="form-control" ng-model="registerUser.name" name="registerName" required/>
                                </div>

                                <div class="form-group" ng-class="{'has-error': registerForm.registerSurname.$invalid, 'has-success':registerForm.registerSurname.$valid}">
                                    <label>Surname *</label>
                                    <input type="text" class="form-control" ng-model="registerUser.surname" name="registerSurname" required/>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group" ng-class="{'has-error': registerForm.registerEmail.$invalid, 'has-success':registerForm.registerEmail.$valid}">
                                    <label>Email *</label>
                                    <input type="email" class="form-control" ng-model="registerUser.email" ng-pattern="/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/" name="registerEmail" required/>
                                </div>
                                <div class="form-group" ng-class="{'has-error': registerForm.registerPhone.$invalid, 'has-success':registerForm.registerPhone.$valid}">
                                    <label>Phone *</label>
                                    <input type="text" class="form-control" ng-model="registerUser.phone" name="registerPhone" required/>
                                </div>
                                <div class="form-group" ng-class="{'has-error': registerForm.registerAddress.$invalid, 'has-success':registerForm.registerAddress.$valid}">
                                    <label>Address *</label>
                                    <input type="text" class="form-control" ng-model="registerUser.address" name="registerAddress" required/>
                                </div>
                                <div class="form-group">         
                                    <label>Province</label>
                                    <select class="form-control" ng-model="province" name="registerProvince" ng-change="chargeCity()" ng-options="object.PRO for object in provinces track by object.CPRO">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <select class="form-control" ng-model="city" name="registerCity" ng-change="loadZipCode()" ng-options="object.DMUN50 for object in cities track by object.CMUM">
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group" ng-class="{'has-error': registerForm.registerUserImage.$invalid, 'has-success':registerForm.registerUserImage.$valid}">
                                    <label>User Image *</label>
                                    <input type="file" file="image" accept="image/*" id="registerUserImage" name="registerUserImage" required/>
                                </div>
                            </div>


                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" ng-disabled="registerForm.$invalid">Register</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </body>
</html>
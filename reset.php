<!DOCTYPE html>
<?php
session_start();

if (isset($_SESSION['connectedUser'])) {
    header("Location: main.php");
}
?>

<html ng-app="RestaurantAppReset">
    <head>
        <title>Restaurant Management</title>
        <link rel="icon" href="../images/LOGO-PROJECT.png" type="image/png"/>

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

        <!--Model-->
        <script src="js/model/Users/UserObj.js" type="text/javascript"></script>
        <!-- Index Control-->
        <script src="js/control/generalFunctions.js" type="text/javascript"></script>
        <script src="js/control/reset.js" type="text/javascript"></script>

    </head>
    <body ng-controller="resetController as resetCtrl">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        <img class="img-thumbnail" src="images/LOGO-PROJECT.png" alt="" width="50" height="50"/>

                    </a>
                    <a class="navbar-brand">"Restaurant Name"</a>
                </div>
            </div>
        </nav>
        
        <div class="modal-dialog modal-sm" role="document">
            <div class="container-fluid">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="modalLogin">Reset your Password</h4>
                </div>
                <div class="modal-body">                        
                    <form action="" method="POST" name="resetForm" ng-submit="resetPassword()" novalidate >
                        <div class="form-group">
                            <label for="passwd1">Password:</label>
                            <input type="text" name="password1" ng-model="user.password" class="form-control" id="usr1">
                            <label for="passwd1">Repeat the password:</label>
                            <input type="text" name="password2" ng-model="passwd2" class="form-control" id="usr2">
                            <span ng-show="samePasswords">The passwords are equal</span>
                            <span ng-show="!samePasswords">The passwords are not equal</span>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="reset" class="btn btn-primary" ng-disabled="resetForm.$invalid">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <footer class="navbar navbar-default navbar-fixed-bottom">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand footer-brand" href="#">Created by Rifat Momin and Victor Moreno</a>
                </div>
            </div>
        </footer>
        <div class="form-group">

        </div>

    </body>
</html>



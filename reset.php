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
        <link href="../css/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <link href="../css/index.css" rel="stylesheet" type="text/css"/>

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
                    <a class="navbar-brand" href="#">
                        <img class="img-thumbnail" src="images/LOGO-PROJECT.png" alt="" width="50" height="50"/>

                    </a>
                    <a class="navbar-brand">"Restaurant Name"</a>
                </div>

                <div class="modal fade" id="retrieveModal" tabindex="-1" role="dialog" aria-labelledby="modalRetrieve">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title text-center" id="modalLogin">Reset Password</h4>
                            </div>
                            <div class="modal-body">                        
                                <form action="" method="POST" name="resetForm" ng-submit="resetPassword()" novalidate >
                                    <div class="form-group">
                                        <label for="usr">Password:</label>
                                        <input type="text" name="password1" class="form-control" id="usr1">
                                        <input type="text" name="password2" class="form-control" id="usr2">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="reset" class="btn btn-primary" ng-disabled="resetForm.$invalid">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
        <div class="form-group">

        </div>

        <?php
        if (isset($_POST['reset'])) {
            if (password1 != null && password1 != null) {
                $encrypt = mysqli_real_escape_string($connection, $_GET['encrypt']);
                $query = "SELECT user_id FROM users where md5(90*13+id)='" . $encrypt . "'";
                $result = mysqli_query($connection, $query);
                $Results = mysqli_fetch_array($result);
                if (count($Results) >= 1) {
                    
                } else {
                    $message = 'Invalid key please try again. <a href="http://localhost/templates/retrieve.php">Forget Password?</a>';
                }
            }
        } elseif (isset($_POST['reset'])) {

            $encrypt = mysqli_real_escape_string($connection, $_POST['action']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $query = "SELECT id FROM users where md5(90*13+id)='" . $encrypt . "'";

            $result = mysqli_query($connection, $query);
            $Results = mysqli_fetch_array($result);
            if (count($Results) >= 1) {
                $query = "update users set password='" . md5($password) . "' where id='" . $Results['id'] . "'";
                mysqli_query($connection, $query);

                $message = "Your password changed sucessfully <a href=\"http://localhost/RestaurantManagement_1/index.php/\">click here to login</a>.";
            } else {
                $message = 'Invalid key please try again. <a href="http://localhost/templates/retrieve">Forget Password?</a>';
            }
        } else {
            echo "hola";
            //header("location: /login-signup-in-php");
        }
        ?>
    </body>
</html>



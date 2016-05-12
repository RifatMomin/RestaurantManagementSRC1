/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

});


/**
 * AngularJS Code
 * @author Rifat Momin and Victor Moreno
 */
(function () {
    var restaurantApp = angular.module("restaurantApp", ['angular-media-preview']);

    restaurantApp.controller("restaurantController", function ($scope, $http, accessService, $log) {
        //Scope variables
        $scope.action = 5;
        $scope.userLoggedIn = new UserObj();
        $scope.beforeUser = new UserObj();
        $scope.restaurantInfo = new RestaurantObj();
        $scope.rolePage = 0;
        $scope.roleName = "";
        $scope.availableUser = true;
        $scope.availableEmail = true;
        $scope.incorrectUserPassword = false;


        $scope.showEditImage = function (showImage) {
            $("#editImage").show(500);
            $("#userImage").hide(500);
            $("#buttonShowImage").hide(500);
            $("img.media-preview").show(500);
            $("#buttonCancelImage").show();
        };

        $scope.openModalData = function () {
            //Show, hide and empty all elements of the form
            $("#editImage").hide();
            $("#userImage").show();
            $("#editUserImage").val("");
            $("#containerImage").html("");
            $("#buttonShowImage").show();
            $("img.media-preview").hide();
            $("#buttonCancelImage").hide();

            //Once is clean, open the modal
            $("#myDataModal").modal("show");
        };

        /**
         * @description The server has the userType stored in a $_SESSION vairable
         * so we go to it and retrieve the userType to show the pertinent content
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/09
         */
        $scope.checkUserType = function () {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10550, JSONData: JSON.stringify({none: ""})});

            promise.then(function (data) {
                if (data[0] === true) {
                    $scope.rolePage = parseInt(data[1]);
                    switch ($scope.rolePage) {
                        case 1:
                            $scope.roleName = "(Chef)";
                            break;
                        case 2:
                            $scope.roleName = "(Waiter)";
                            break;
                        case 3:
                            $scope.roleName = "(Admin)";
                            break;
                        default:
                            $scope.roleName = "";
                            break;
                    }
                } else {
                    window.open("index.php", "_self");
                }
            });
        };

        /**
         * @description Gets th restaurant info from the Database
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.getRestaurantInfo = function () {
            $scope.restaurantInfo = new RestaurantObj();

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 2, action: 1, JSONData: JSON.stringify({none: ""})});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.restaurantInfo.construct(data[1][0].restaurant_id, data[1][0].CIF, data[1][0].name, data[1][0].address, data[1][0].city, data[1][0].zip_code, data[1][0].phone1, data[1][0].phone2, data[1][0].email, data[1][0].description);
                        document.title = $scope.restaurantInfo.getName();
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        $scope.getUserInfo = function () {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10570, JSONData: JSON.stringify("")});


            promise.then(function (data) {
                if (data[0] === true) {
                    $scope.userLoggedIn.construct(data[1].id, data[1].username, '', data[1].name, data[1].surname, data[1].email, data[1].phone, data[1].address, data[1].city, data[1].zipCode, data[1].image, data[1].registerDate, '');
                    $scope.beforeUser = angular.copy($scope.userLoggedIn);

                    $('[data-toggle="popover"]').popover({
                        animation: true,
                        html: true,
                        trigger: 'hover',
                        placement: 'bottom',
                        content: "<img width='auto' height='75' src='" + $scope.userLoggedIn.getImage() + "' alt='" + $scope.userLoggedIn.getUsername() + "'/>"
                    });
                } else {
                    errorGest(data);
                }
            });
        };


        $scope.logOut = function () {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10600, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    window.open("index.php", "_self");
                } else {                    
                    errorGest("Can't log out at this moment, try again later. ");
                }
            });
        };

        /**
         * @description Changes the modal from the register to the Login
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.checkNick = function () {
            if ($scope.modifyDataForm.username.$valid && !angular.equals($scope.userLoggedIn.getUsername(), $scope.beforeUser.getUsername())) {
                var nick = $scope.userLoggedIn.getUsername();
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10250, JSONData: JSON.stringify({nick: nick})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.availableUser = false;
                    } else {
                        $scope.availableUser = true;
                    }
                });
            }
        };

        /**
         * @description Checks in real time the email introduced by the user to
         * see if is available
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.checkEmail = function () {
            if ($scope.modifyDataForm.email.$valid && !angular.equals($scope.userLoggedIn.getEmail(), $scope.beforeUser.getEmail())) {
                var email = $scope.userLoggedIn.getEmail();
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10251, JSONData: JSON.stringify({email: email})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.availableEmail = false;
                        $scope.modifyDataForm.$invalid = false;
                    } else {
                        $scope.availableEmail = true;
                    }
                });
            }

        };

        $scope.updateInfo = function () {
            //Get the image
            var imageFile = $("#editUserImage")[0].files[0];
            var imagesArrayToSend = new FormData();
            imagesArrayToSend.append('images[]', imageFile);

            //Check if the image is putted in the input or not
            if ($("#editUserImage")[0].files.length > 0) {
                //Upload the image first.
                //If the upload fails, don't upload the user information
                $http({
                    method: 'POST',
                    url: 'php/controllers/MainController.php?JSONData=""&controllerType=9&action=260',
                    headers: {'Content-Type': undefined},
                    data: imagesArrayToSend,
                    transformRequest: function (data, headersGetterFunction) {
                        return data;
                    }
                }).success(function (data) {
                    if (data[0] === true) {
                        //Image has been putted in the server correctly, now update the user Info
                        $scope.userLoggedIn.setImage("images/users/" + data[1]);
                        $scope.userLoggedIn = angular.copy($scope.userLoggedIn);

                        var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10520, JSONData: JSON.stringify($scope.userLoggedIn)});

                        promise.then(function (data) {
                            if (data[0] === true) {
                                successMessage("Info updated!");
                                //Wait one second to reload the page
                                setTimeout(function(){
                                    location.reload();
                                }, 1000);                                
                            } else {
                                errorGest(data);
                            }
                        });
                    } else {
                        errorGest(data);
                    }
                });

            } else {
                $scope.userLoggedIn = angular.copy($scope.userLoggedIn);

                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10520, JSONData: JSON.stringify($scope.userLoggedIn)});

                promise.then(function (data) {
                    if (data[0] === true) {
                        if (data[1] === false) {
                            $("#myDataModal").modal("hide");
                        } else {
                            successMessage("Info updated! ");
                            $("#myDataModal").modal("hide");
                        }
                    } else {
                        errorGest(data);
                    }
                });
            }
        };

        $scope.showChangePass = function () {
            $("#myDataModal").modal("hide");
            $("#changePassModal").modal("show");
        };


        $scope.changePassword = function(){
           //Get the passwords entered by the user
            var actualPass = angular.copy($scope.userLoggedIn.cryptPassword());
            var pass1 = CryptoJS.SHA1($scope.passwordOne).toString();
            var pass2 = CryptoJS.SHA1($scope.passwordTwo).toString();
            
            //Validate the first Password
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10700, JSONData: JSON.stringify({actualPassword: actualPass})});            
            
            promise.then(function(data){
                if(data[0]===true){
                    $scope.incorrectUserPassword = false;
                    //Change the password in the server
                    var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10710, JSONData: JSON.stringify({pass1: pass1, pass2: pass2})});            
                    
                    promise.then(function(data){
                        if(data[0]===true){
                            successMessage(data[1]);
                            $("#changePassModal").modal("hide");
                        }else{
                            errorGest("Can't change the password at this moment, try again later");
                        }
                    });
                }else{
                    //Show the error that the password is incorrect
                    $scope.incorrectUserPassword = true;
                }
            });
            
        };

        $scope.saveRestaurantInfo = function () {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 2, action: 3, JSONData: JSON.stringify($scope.restaurantInfo)});

            promise.then(function (data) {
                console.log(data);
                if (data[0] === true) {
                    alert("Restaurant information updated");
                } else {

                    if (angular.isArray(data[1])) {
                        showErrors(data[1]);
                    } else {
                        showNormalError("An error occurred in the server, please come back later!");
                    }
                }
            });
        }
    });

    //Navbar options templates
    restaurantApp.directive("customerNav", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/navbar/customerNav.html",
            controller: function () {

            },
            controllerAs: 'customerNav'
        };
    });

    restaurantApp.directive("adminNav", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/navbar/adminNav.html",
            controller: function () {

            },
            controllerAs: 'adminNav'
        };
    });

    restaurantApp.directive("chefNav", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/navbar/chefNav.html",
            controller: function () {

            },
            controllerAs: 'chefNav'
        };
    });

    restaurantApp.directive("waiterNav", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/navbar/waiterNav.html",
            controller: function () {

            },
            controllerAs: 'waiterNav'
        };
    });
    
    restaurantApp.directive("restaurantInfoTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/CRUDRestaurant/restaurantInfoTemplate.html",
            controller: function () {

            },
            controllerAs: 'restaurantInfoTemplate'
        };
    });





    restaurantApp.directive("footerTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/footerTemplate.html",
            controller: function () {

            },
            controllerAs: 'footerTemplate'
        };
    });

    restaurantApp.directive("templateModifyUserData", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/templateModifyUserData.html",
            controller: function () {

            },
            controllerAs: 'templateModifyUserData'
        };
    });

    restaurantApp.directive("errorMessage", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/errorMessage.html",
            controller: function () {

            },
            controllerAs: 'errorMessage'
        };
    });
    
    restaurantApp.directive("successMessage", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/successMessage.html",
            controller: function () {

            },
            controllerAs: 'successMessage'
        };
    });


    restaurantApp.factory('accessService', function ($http, $log, $q) {
        return {
            getData: function (url, async, method, params, data) {
                var deferred = $q.defer();
                $http({
                    url: url,
                    method: method,
                    asyn: async,
                    params: params,
                    data: data
                })
                        .success(function (response, status, headers, config) {
                            deferred.resolve(response);
                        })
                        .error(function (msg, code) {
                            deferred.reject(msg);
                            $log.error(msg, code);
                            alert("There has been an error in the server, try later");
                        });

                return deferred.promise;
            }
        };
    });
})();


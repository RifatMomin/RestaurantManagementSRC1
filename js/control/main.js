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

    restaurantApp.controller("restaurantController", function ($scope, $http, accessService) {
        //Scope variables
        $scope.action = 5;
        $scope.userLoggedIn = new UserObj();
        $scope.beforeUser = new UserObj();
        $scope.restaurantInfo = new RestaurantObj();
        $scope.rolePage = 0;
        $scope.availableUser = true;
        $scope.availableEmail = true;



        $scope.showEditImage = function (showImage) {
            $("#editImage").show(750);
            $("#userImage").hide(500);
            $("#buttonShowImage").hide(500);
            $("img.media-preview").show(500);
        };
        
        $scope.resetImage = function(){
            $("#editImage").hide();
            $("#userImage").show();
            $("#buttonShowImage").show();
            $("img.media-preview").hide();
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
                } else {
                    window.open("index.php", "_self");
                }
            });
        }

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
                        //console.log($scope.theRestaurant);
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        $scope.getUserInfo = function () {
            //var userAux = JSON.parse(sessionStorage.getItem("connectedUser"));

            //$scope.userLoggedIn.construct(userAux.id, userAux.username, '', userAux.name, userAux.surname, userAux.email, userAux.phone, userAux.address, userAux.city, userAux.zipCode, userAux.image, '', '');
            
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10570, JSONData: JSON.stringify("")});
            
            
            promise.then(function(data){
                console.log(data);
            });
            
//            $scope.beforeUser = angular.copy($scope.userLoggedIn);
//
//            console.log($scope.userLoggedIn);
        };


        $scope.logOut = function () {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10600, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    window.open("index.php", "_self");
                } else {
                    showNormalError("Can't log out at this moment, try again later. ");
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
                    console.log(data);
                    if (data[0] === true) {
                        $scope.availableUser = false;
                    } else {
                        $scope.availableUser = true
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
                    console.log(data);
                    if (data[0] === true) {
                        $scope.availableEmail = false;
                        $scope.modifyDataForm.$invalid = false;
                    } else {
                        $scope.availableEmail = true
                    }
                });
            }

        };

        $scope.updateInfo = function () {
            console.log($scope.userLoggedIn);
            //Get the image
            var imageFile = $("#editUserImage")[0].files[0];
            var imagesArrayToSend = new FormData();
            imagesArrayToSend.append('images[]', imageFile);
            
            
            if ($("#editUserImage")[0].files.length > 0) {
                //Upload the image first.
                //If the upload fails, don't upload the user information
                $http({
                    method: 'POST',
                    url: 'php/controllers/MainController.php?JSONData=""&controllerType=9&action=260&actualImage='+$scope.userLoggedIn.getImage()+'&userName=' + $scope.userLoggedIn.getUsername(),
                    headers: {'Content-Type': undefined},
                    data: imagesArrayToSend,
                    transformRequest: function (data, headersGetterFunction) {
                        return data;
                    }
                }).success(function (data) {
                    console.log(data);
                    if (data[0] === true) {
                        
                    } else {
                       // errorGest(data);
                    }
                });

            }
            
//            $scope.userLoggedIn = angular.copy($scope.userLoggedIn);
//
//
//            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10520, JSONData: JSON.stringify($scope.userLoggedIn)});
//
//            promise.then(function (data) {
//                console.log(data);
//                if (data[0] === true) {
//                    if (data[1] === false) {
//                        $("#myDataModal").modal("hide");
//                    } else {
//                        console.log(data);
//                        createLocalSession(data[1]);
//                        $("#myDataModal").modal("hide");
//                    }
//                } else {
//                    errorGest(data);
//                }
//            });
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


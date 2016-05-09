/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function () {
    var mainApp = angular.module("RestaurantAppReset", []);

    mainApp.controller("resetController", function ($http, $scope, accessService) {

        //scope variables        
        $scope.user = new UserObj();
        //$scope.restaurantInfo = new RestaurantObj();
        $scope.passwd1;
        $scope.passwd2;
        $scope.samePasswd = false;
        $scope.ObjectPasswordArray = new Array();

        /**
         * @description Shows the user to retrieve his password
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/04
         */
        $scope.resetPassword = function () {

            //get the encriptation in url to decode
            var url = window.location.search;
            var res = url.split("=");
            var url = res[1];

            //var hash = CryptoJS.MD5($scope.user.email+$scope.user.password);
            //alert(hash);

            $scope.user = angular.copy($scope.user);
            $scope.ObjectPasswordArray = [$scope.user, $scope.passwd2, url];

            if ($scope.passwd1 == $scope.passwd2 && $scope.passwd1!=null && $scope.passwd2!=null) {
                //Server conenction to verify user's data
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10300, JSONData: JSON.stringify($scope.ObjectPasswordArray)});

                promise.then(function (data) {
                    console.log(data);
                    
                    if (data[0] === true) {
                        window.open("index.php", "_self");
                    } else {
                        if (angular.isArray(data[1])) {
                            showErrors(data[1]);
                        } else {
                            showNormalError("An error occurred in the server, please come back later!");
                        }
                    }
                });
            }
            else {
                showNormalError("Please input same valid passwords");
            }
        };

        /**
         * @description compares both passwords
         * if they're not equal, sends error
         * @version 1
         * @author RifatMomin
         * @date 2016/05/06
         */
        $scope.comparePasswords = function () {
            if ($scope.resetForm.resetPassword.$valid) {
                if ($scope.user.password == $scope.password2) {
                    $scope.samePasswd = true;
                } else {
                    $scope.samePasswd = false;
                }
            }
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
                        console.log($scope.restaurantInfo);
                    }
                } else {
                    errorGest(data);
                }
            });

        };


    });

    mainApp.factory('accessService', function ($http, $log, $q) {
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
    
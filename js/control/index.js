/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    var sideslider = $('[data-toggle=collapse-side]');
    var sel = sideslider.attr('data-target');
    var sel2 = sideslider.attr('data-target-2');
    sideslider.click(function (event) {
        $(sel).toggleClass('in');
        $(sel2).toggleClass('out');
    });
});

(function () {
    var mainApp = angular.module("mainRestaurantApp", ["GeoAPI"]);

    mainApp.controller("sessionController", function ($http, $scope, accessService, $log, GeoAPI) {

        //scope variables        
        $scope.user = new UserObj();
        $scope.registerUser = new UserObj();
        $scope.usernameValid = true;
        $scope.passwordValid = true;
        $scope.userAction = 0;
        $scope.provinces = [];
        $scope.cities = [];
        $scope.zipCode;
        $scope.availableUser = true;
        $scope.availableEmail = true;
        $scope.equalPasswords = false;

        //Initialize registerUser
        //$scope.registerUser.construct(0, "username", "password", "name", "surname", "email@gmail.com", "938855487", "address", "", "", "", "", "");

        //Configuration of the GeoAPI
        GeoAPI.setConfig("key", "06649ff9b93c721316323326b30bda68f5dc8744b8f31a0c2c5961daf87c575e");
        GeoAPI.setConfig("type", "JSON");
        GeoAPI.setConfig("sandbox", 0);

        /**
         * @description Loads the provencies from SPAIN using a GET service API
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/05
         */
        $scope.loadProvinces = function () {
            GeoAPI.provincias({
                //Charge the comunities from Spain in JSON format
            }).then(function (data) {
                $scope.provinces = data['data'];
                $scope.province = data['data'][0];
                $scope.chargeCity();
            });
        };

        /**
         * @description Loads the cities depending on the province using a GET service API
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/05
         */
        $scope.chargeCity = function () {
            GeoAPI.municipios({
                //Charge the cities depending on the province selected
                CPRO: $scope.province.CPRO
            }).then(function (data) {
                $scope.cities = data['data'];
                $scope.city = data['data'][0];
                $scope.registerUser.setCity(data['data'][0].DMUN50);
                $scope.loadZipCode();
            });
        };

        /**
         * @description Loads the zip code of the city using a GET service API
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/05
         */
        $scope.loadZipCode = function () {
            //console.log($scope.city);

            GeoAPI.nucleos({
                CPRO: $scope.province.CPRO,
                CMUM: $scope.city.CMUM,
                NENTSI50: $scope.city.DMUN50
            }).then(function (data) {
                try {
                    $scope.city.CUN = data['data'][0].CUN;
                    GeoAPI.cps({
                        CPRO: $scope.province.CPRO,
                        CUN: $scope.city.CUN,
                        CMUM: $scope.city.CMUM
                    }).then(function (dataCP) {
                        $scope.zipCode = dataCP['data'][0].CPOS;
                    });
                } catch (e) {
                    $scope.zipCode = 00000;
                }
            });
        };


        /**
         * @description Logins to the app connecting to the server
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/04
         */
        $scope.connection = function () {
            //copy 
            $scope.user.cryptPassword();
            $scope.user = angular.copy($scope.user);

            //Server conenction to verify user's data
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10010, JSONData: JSON.stringify($scope.user)});

            promise.then(function (data) {
                $scope.user.setPassword("");
                if (data[0] === true) {
                    //Create local session
                    createLocalSession(data[1][0]);

                    window.open("main.php", "_self");
                } else {
                    //If user is incorrect, show errors
                    if (angular.isArray(data[1])) {
                        showErrors(data[1]);
                    } else {
                        showNormalError("An error occurred in the server, please come back later!");
                    }
                }
            });
        };

        /**
         * @description Reloads the login form and the user object
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.reloadLogin = function () {
            $scope.user = new UserObj();
            $scope.loginForm.$setPristine();
        };

        /**
         * @description Shows the user to retrieve his password
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/04
         */
        $scope.retrievePassword = function () {
            $scope.user = angular.copy($scope.user);
            //Server conenction to verify user's data
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10200, JSONData: JSON.stringify($scope.user)});

            promise.then(function (data) {
                if (data[0] === true) {
                    window.open("reset.php", "_self");
                } else {
                    if (angular.isArray(data[1])) {
                        showErrors(data[1]);
                    } else {
                        showNormalError("An error occurred in the server, please come back later!");
                    }
                }
            });
        };

        /**
         * @description Sends to the server the user to register in the App
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/05
         */
        $scope.register = function () {
            $scope.registerUser.cryptPassword();
            $scope.registerUser.setCity($scope.city.DMUN50);
            $scope.registerUser.setZip_code($scope.zipCode);
            
            console.log($scope.registerUser);
            $scope.registerUser = angular.copy($scope.registerUser);



            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10150, JSONData: JSON.stringify($scope.registerUser)});

            promise.then(function (data) {
                if (data[0] === true) {
                    $("#modalRegisteredUser").modal("show");
                    $scope.reloadRegister();
                } else {
                    if (angular.isArray(data[1])) {
                        showErrors(data[1]);
                    } else {
                        showNormalError("An error occurred in the server, please come back later!");
                    }
                }
            });
        };

        /**
         * @description Reloads the register form and the registerUser object
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.reloadRegister = function () {
            $scope.registerUser = new UserObj();
            $scope.loginForm.$setPristine();
        };

        /**
         * @description Changes the modal from the register to the Login
         * to see if is available
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.changeRegisterToLogin = function () {
            $("#signUpModal").modal("hide");
            $("#loginModal").modal("show");
        };

        /**
         * @description Changes the modal from the register to the Login
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.checkNick = function () {
            if ($scope.registerForm.registerUsername.$valid) {
                var nick = $scope.registerUser.getUsername();
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
            if ($scope.registerForm.registerEmail.$valid) {
                var email = $scope.registerUser.getEmail();
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10251, JSONData: JSON.stringify({email: email})});

                promise.then(function (data) {
                    console.log(data);
                    if (data[0] === true) {
                        $scope.availableEmail = false;
                        $scope.registerForm.$invalid = false;
                    } else {
                        $scope.availableEmail = true
                    }
                });
            }

        };

        /**
         * @description Compares the two passwords introduced by the user, and sets 
         * the scope to false if they aren't equals
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.checkPasswords = function () {
            if ($scope.registerForm.registerPassword.$valid) {
                if ($scope.registerUser.password == $scope.repeatPassword) {
                    $scope.equalPasswords = true;
                } else {
                    $scope.equalPasswords = false;
                }
            }
        };

        /**
         * @description Change the modal from the welcome to the Login
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.changeModals = function () {
            $("#loginModal").modal("hide");
        }
    });


    //Templates
    mainApp.directive("menusTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/menusTemplate.html",
            controller: function () {

            },
            controllerAs: 'menusTemplate'
        };
    });

    mainApp.directive("contactTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/contactTemplate.html",
            controller: function () {

            },
            controllerAs: 'contactTemplate'
        };
    });

    mainApp.directive("retrieveTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/retrieveTemplate.html",
            controller: function () {

            },
            controllerAs: 'retrieveTemplate'
        };
    });

    mainApp.directive("loginTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/loginTemplate.html",
            controller: function () {

            },
            controllerAs: 'loginTemplate'
        };
    });

    mainApp.directive("registerTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/registerTemplate.html",
            controller: function () {

            },
            controllerAs: 'registerTemplate'
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

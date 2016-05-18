/**
 * @name Index.js
 * @description The Index JS file attempts to control the functions of the 
 * principal page like the first content loader, the basic connections to the server 
 * (insert users, get information, manage basic displaying effects...). It has
 * two parts differenced: the jQuery code and the Angular JS code.
 *
 * @since     1.0.0
 * @requires AngularJS, jQuery Framework, CryptoJS Library
 * @author Victor Moreno García / Rifat Momin Momin
 * @date 2016/05/01
 */

/////////////////////////

/**
 * JQUERY CODE
 * @author Victor Moreno García
 */
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Prevent default anchor click behavior
    event.preventDefault();

    // Store hash
    var hash = this.hash;

    // Using jQuery's animate() method to add smooth page scroll
    // The optional number (1000) specifies the number of milliseconds it 
    // takes to scroll to the specified area
    $('html, body').animate({
      scrollTop: $(hash).offset().top
    }, 1000, function(){
   
      // Add hash (#) to URL when done scrolling (default click behavior)
      window.location.hash = hash;
    });
  });
});

/**
 * ANGULARJS CODE
 * @author Victor Moreno García and Rifat Momin Momin
 */
(function () {
    var mainApp = angular.module("mainRestaurantApp", ["GeoAPI",'angularUtils.directives.dirPagination']);

    mainApp.controller("mainAppController", function ($http, $scope, accessService, $log, GeoAPI) {
        //Empty the session in the local storage
        sessionStorage.removeItem("connectedUser");

        //scope variables       
        $scope.restaurantInfo = new RestaurantObj();
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
        $scope.menuItem = new MenuItemObj();
        $scope.menuItemsArray = [1];
        $scope.restaurantStreetMap = "";
        $scope.allMenus = [];
        
        //Reviews Paginate
        $scope.pageSize = 1;
        $scope.currentPage = 1;
        
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
                    $scope.zipCode = "00000";
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
            var password = $scope.user.cryptPassword();
            $scope.user = angular.copy($scope.user);

            //Server conenction to verify user's data
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10010, JSONData: JSON.stringify({user: $scope.user, pass: password})});

            promise.then(function (data) {
                $scope.user.setPassword("");
                if (data[0] === true) {
                    window.open("main.php", "_self");
                } else {
                    errorGest(data);
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
                    errorGest(data);
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
            //Get the image
            var imageFile = $("#registerUserImage")[0].files[0];
            var imagesArrayToSend = new FormData();
            imagesArrayToSend.append('images[]', imageFile);

            //Check if the user wants to upload an image
            if ($("#registerUserImage")[0].files.length > 0) {
                //Upload the image first.
                //If the upload fails, don't upload the user information
                $http({
                    method: 'POST',
                    url: 'php/controllers/MainController.php?JSONData=""&controllerType=9&action=250&userName=' + $scope.registerUser.username,
                    headers: {'Content-Type': undefined},
                    data: imagesArrayToSend,
                    transformRequest: function (data, headersGetterFunction) {
                        return data;
                    }
                }).success(function (data) {
                    if (data[0] === true) {
                        if (angular.isString(data[1])) {
                            //Set all the user properties to register it to the app
                            $scope.registerUser.cryptPassword();
                            $scope.registerUser.setCity($scope.city.DMUN50);
                            $scope.registerUser.setZip_code($scope.zipCode);
                            $scope.registerUser = angular.copy($scope.registerUser);
                            $scope.registerUser.setImage("images/users/" + data[1]);

                            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10150, JSONData: JSON.stringify($scope.registerUser)});

                            promise.then(function (data) {
                                console.log(data);
                                if (data[0] === true) {
                                    var id = data[1].id;
                                    $scope.insertClient(id);
                                    $scope.reloadRegister();
                                } else {
                                    $scope.reloadRegister();
                                    errorGest(data);
                                }
                            });
                        }
                    } else {
                        errorGest(data);
                    }
                });

            } else {
                $scope.registerUser.cryptPassword();
                $scope.registerUser.setCity($scope.city.DMUN50);
                $scope.registerUser.setZip_code($scope.zipCode);
                $scope.registerUser.setImage("images/users/user.jpg");

                $scope.registerUser = angular.copy($scope.registerUser);


                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10150, JSONData: JSON.stringify($scope.registerUser)});

                promise.then(function (data) {
                    if (data[0] === true) {
                        var id = data[1].id;
                        $scope.insertClient(id);
                        $scope.reloadRegister();
                    } else {
                        //$scope.reloadRegister();
                        errorGest(data);
                    }
                });
            }
        };
        
        /**
         * @name insertClient
         * @description Inserts a client into the database
         * @version 1
         * @author Rifat Momin / Victor Moreno
         * @date 2016/05/10
         * @param id the id of the user to insert into the clients
         */
        $scope.insertClient = function (id) {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10230, JSONData: JSON.stringify({id: id})});

            promise.then(function (data) {
                if (data[0] === true) {
                    $("#modalRegisteredUser").modal("show");
                } else {
                    errorGest(data);
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
            $("#registerUserImage").val("");
            $scope.registerUser = new UserObj();
            $scope.repeatPassword = "";
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
                    }
                } else {
                    errorGest(data);
                }
            });

        };

        /**
         * @description Returns all menus from the database
         * @version 1
         * @author Rifat Momin / Victor Moreno
         * @date 2016/05/10
         */
        $scope.getMenus = function () {
            $scope.allMenus = [];

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10025, JSONData: JSON.stringify({none: ""})});

            promise.then(function (data) {
                //console.log(data);
                if (data[0] === true) {
                    if(angular.isArray(data[1])){
                        //Iterate all the menus
                        $.each(data[1],function(index){           
                            $scope.allMenus.push(data[1][index]);                            
                        });
                        //$("#imageMenu0").addClass("active");//imageMenu{{$index}}
                        //$log.info($scope.allMenus);
                    }else{
                        errorGest("An error occured in the server, please try again later");
                    }
                    
                    $("#imageMenu0").addClass("active");
                }
                else {
                    errorGest(data);
                }
            });

        };
        
        /**
         * @name getReviews
         * @description Returns all the reviews from the database. The JSON is passed
         * directly as an object, so we don't need to parse it into an object of
         * JS
         * @version 1
         * @author Rifat Momin / Victor Moreno
         * @date 2016/05/15
         */
        $scope.getReviews = function(){
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 4, action: 1, JSONData: JSON.stringify({none: ""})});
            promise.then(function(data){
                if(data[0]===true){
                    if(angular.isArray(data[1])){
                        $scope.reviews = data[1];
                        $log.info($scope.reviews);
                    }
                }else{
                    errorGest(data);
                }
            });
        
        };  

    });


    /*
     * ***** TEMPLATES *****
     * 
     * The templates are used to display different contents on the page
     * without change the location of the URL
     */
    
    mainApp.directive("menusTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/menusTemplate.html",
            controller: function () {

            },
            controllerAs: 'menusTemplate'
        };
    });

    mainApp.directive("footerTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/footerTemplate.html",
            controller: function () {

            },
            controllerAs: 'footerTemplate'
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
    
    mainApp.directive("reviewsTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/reviewsTemplate.html",
            controller: function () {

            },
            controllerAs: 'reviewsTemplate'
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
    
    mainApp.directive("errorMessage", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/errorMessage.html",
            controller: function () {

            },
            controllerAs: 'errorMessage'
        };
    });
    
    mainApp.directive("successMessage", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/successMessage.html",
            controller: function () {

            },
            controllerAs: 'successMessage'
        };
    });

    
    //Access service. 
    //This service allows to AngularJS to receive and send information using
    //AJAX and JSON
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
        }
        ;
    });
})();

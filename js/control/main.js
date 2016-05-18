/**
 * @name Main.js
 * @description The Main JS file attempts to control the functions of the 
 * main app page. It has two differenced parts: the jQuery Code and the Angular JS code. 
 * In the Angular JS code, qe can found functions like update info of the user, 
 * make new orders, control the roles of the page (admin, chef, waiter, cusotmer) 
 * and many other functions
 *
 * @since     1.0.0
 * @requires AngularJS, jQuery Framework, CryptoJS Library
 * @author Victor Moreno García / Rifat Momin Momin
 * @date 2016/05/01
 */

/////////////////////////

/**
 * JQUERY CODE
 */
$(document).ready(function () {
    
});


/**
 * AngularJS Code
 * @author Rifat Momin Momin and Victor Moreno
 */
(function () {
    var restaurantApp = angular.module("restaurantApp", ['angular-media-preview', 'angularUtils.directives.dirPagination', 'ng-currency']);

    /**
     * This the principal CONTROLLER of the main.js page. 
     */
    restaurantApp.controller("restaurantController", function ($scope, $http, accessService, $log) {
        //Scope variables
        $scope.action = 5;
        $scope.userLoggedIn = new UserObj();
        $scope.beforeUser = new UserObj();
        $scope.restaurantInfo = new RestaurantObj();
        $scope.RestaurantObjsArray = new Array();
        $scope.rolePage = 0;
        $scope.roleName = "";
        $scope.availableUser = true;
        $scope.availableEmail = true;
        $scope.incorrectUserPassword = false;
        $scope.AdminRestaurantAction = 0;
        $scope.equalPhoneNumbers= false;
        $scope.registerPhoneNumbers=false;

        /**
         * @name showEditImage
         * @description Shows the content to edit the image of the actual user
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/12
         */
        $scope.showEditImage = function () {
            $("#editImage").show(500);
            $("#userImage").hide(500);
            $("#buttonShowImage").hide(500);
            $("img.media-preview").show(500);
            $("#buttonCancelImage").show();
        };

        /**
         * @name openModalData
         * @description Opens the modal of the user data, it also does the necessary
         * steps to clear the presentation of the image preview (hide in beggining).
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/12
         */
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
         * @name checUserType
         * @description The server has the userType stored in a $_SESSION variable
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
         * @name getRestaurantInfo
         * @description Gets the restaurant info from the Database
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
         * @name getUserInfo
         * @description Gets the info of th user logged in from the database
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
        $scope.getUserInfo = function () {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10570, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    $scope.userLoggedIn.construct(data[1].id, data[1].username, '', data[1].name, data[1].surname, data[1].email, data[1].phone, data[1].address, data[1].city, data[1].zipCode, data[1].image, data[1].registerDate, '');
                    $scope.beforeUser = angular.copy($scope.userLoggedIn);
                    //Set the image of the user into the popup content
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

        /**
         * @name logOut
         * @description Logs out from the system, killing all sessions
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/06
         */
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
         * @name checkEmail
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

        /**
         * @name updateInfo
         * @description Updates the info of the user. If the user introduces an
         * image, the method will first update the image, if the upload doesn't fails
         * then the user information updated (or not) will be sent to the server to update it
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/08
         */
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
                                setTimeout(function () {
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
                //The user don't want to update the photo so we execute this

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

        /**
         * @name showChangePass
         * @description Shows the modal to change the password
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/13
         */
        $scope.showChangePass = function () {
            $("#myDataModal").modal("hide");
            $("#changePassModal").modal("show");
        };

        /**
         * @name changePassword
         * @description Changes the password of the user.
         * It crypts the passwords with SHA1 before sent it to the server
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/13
         */
        $scope.changePassword = function () {
            //Get the passwords entered by the user
            var actualPass = angular.copy($scope.userLoggedIn.cryptPassword());
            var pass1 = CryptoJS.SHA1($scope.passwordOne).toString();
            var pass2 = CryptoJS.SHA1($scope.passwordTwo).toString();

            //Validate the first Password
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10700, JSONData: JSON.stringify({actualPassword: actualPass})});

            promise.then(function (data) {
                if (data[0] === true) {
                    $scope.incorrectUserPassword = false;
                    //Change the password in the server
                    var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10710, JSONData: JSON.stringify({pass1: pass1, pass2: pass2})});

                    promise.then(function (data) {
                        if (data[0] === true) {
                            successMessage(data[1]);
                            $("#changePassModal").modal("hide");
                        } else {
                            errorGest("Can't change the password at this moment, try again later");
                        }
                    });
                } else {
                    //Show the error that the password is incorrect
                    $scope.incorrectUserPassword = true;
                }
            });

        };

        /**
         * @description Updates restaurant info if existent, 
         * otherwise inserts the info
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/11
         */
        $scope.saveRestaurantInfo = function () {
            //if there restaurant info exists
            if ($scope.restaurantInfo != null) {

                //UPDATE
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 2, action: 3, JSONData: JSON.stringify($scope.restaurantInfo)});

                promise.then(function (data) {
                    
                    if (data[0] === true) {
                        //if restaurant info is existing
                        if (angular.isArray(data[1])) {
                            errorGest("Updated");
                        }
                        else{
                            errorGest("RestauranCould not be updated");
                        }
                    } else {
                        errorGest(data);
                    }
                });
            }
            else{
                
            }


        };
        
        $scope.checkPhoneNumbers = function () {
            if ($scope.restaurantInfoForm.registerPhones.$valid) {
                if ($scope.restaurantInfo.phone1 == $scope.restaurantInfo.phone2) {
                    $scope.equalPhoneNumbers = false;
                } else {
                    $scope.equalPhoneNumbers = true;
                }
            }
        };
        
    });

    /**
     * Controller of the admin
     */
    restaurantApp.controller("adminController", function ($scope, accessService, $log) {
        //Scope variables
        $scope.actionAdmin = 1;//Controls the action of the admin
        $scope.actionMenu = 3; //Cobtrols the action of the CRUD MENU

        //Ingredients
        $scope.ingredients = []; //Array of ingredients
        $scope.newIngredient = new IngredientObj();
        $scope.hideButtonAdd = false;
        $scope.editInputIngredients = [];
        $scope.loadingIngredients = true;
        $scope.ingredientAux = new IngredientObj();
        $scope.editingIngredients = false;
        
        //Pagination
        $scope.pageSize = 5;
        $scope.currentPage = 1;

        /**
         * @name getIngredients
         * @description Gets the ingredients from the database
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.getIngredients = function () {
            $scope.currentPage = 1;
            $scope.ingredients = [];
            $scope.editInputIngredients = [];
            $scope.loadingIngredients = true;
            
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 1, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.ingredients = angular.copy(data[1]);
                        
                        $.each($scope.ingredients,function(index){
                            $scope.editInputIngredients.push(false);
                        });
                        
                        $scope.loadingIngredients = false;
                    }
                } else {
                    errorGest(data);
                }
            });

        };

        /**
         * @name showFromAddNewIngredient
         * @description Shows the form to add a new Ingredient
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.showFromAddNewIngredient = function () {
            $("#buttonAdd").hide();
            $("#newIngredientForm").toggle(800);
        }
        
        /**
         * @name cancelNewIngredient
         * @description Cancels the new Ingredient creation. Putting the object to empty
         * and setting the default style
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.cancelNewIngredient = function(){
            $("#newIngredientForm").toggle(500);
            $("#buttonAdd").fadeIn(500);
            $scope.newIngredient = new IngredientObj();
        };
        
        /**
         * @name addIngredient
         * @description Adds the new ingredient to the database
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.addIngredient = function(){
            $scope.newIngredient = angular.copy($scope.newIngredient);
            
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 2, JSONData: JSON.stringify($scope.newIngredient)});
            
            promise.then(function(data){
                if(data[0]===true){
                    $scope.cancelNewIngredient();
                    $scope.getIngredients();
                    successMessage("Product Inserted correctly");
                }else{
                    errorGest(data);
                }
            });
            
        };
        
        /**
         * @name removeIngredient
         * @description removes the ingredient from the database
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.removeIngredient = function(idIngredient){
            //$log.info(idIngredient);
            if(confirm("Are you sure you want to delete this ingredient?")){
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 3, JSONData: JSON.stringify({id: idIngredient})});
                
                promise.then(function(data){
                    if(data[0]===true){
                        $scope.getIngredients();
                        successMessage("Ingredient Deleted Correctly");
                    }else{
                        errorGest(data);
                    }
                });
            }
        };
        
        $scope.editIngredientForm = function(ingredient){            
            $scope.ingredientAux = angular.copy(ingredient);
                     
              $("#modifyIngredientModal").modal("show");         
            
        };
        
        $scope.modifyIngredient = function(){
            $scope.ingredientAux = angular.copy($scope.ingredientAux);
            
            $log.info($scope.ingredientAux);
            
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 4, JSONData: JSON.stringify($scope.ingredientAux)});
            
            promise.then(function(data){
                if(data[0]===true){
                    
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
    restaurantApp.directive("coursesTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDMenus/coursesTemplate.html",
            controller: function () {
            },
            controllerAs: 'coursesTemplate'
        };
    });
    
    restaurantApp.directive("tableIngredients", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDMenus/tableIngredients.html",
            controller: function () {
            },
            controllerAs: 'tableIngredients'
        };
    });


    restaurantApp.directive("tableMenus", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDMenus/tableMenus.html",
            controller: function () {
            },
            controllerAs: 'tableMenus'
        };
    });

    restaurantApp.directive("adminTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/adminTemplate.html",
            controller: function () {
            },
            controllerAs: 'adminTemplate'
        };
    });

    restaurantApp.directive("menusTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDMenus/menusTemplate.html",
            controller: function () {
            },
            controllerAs: 'menusTemplate'
        };
    });


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


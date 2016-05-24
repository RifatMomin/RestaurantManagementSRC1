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
    $('.btn').button('reset');


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
        $scope.date = new Date();
        $scope.action = 5;
        $scope.userLoggedIn = new UserObj();
        $scope.beforeUser = new UserObj();
        $scope.restaurantInfo = new RestaurantObj();
        $scope.rolePage = 0;
        $scope.roleName = "";
        $scope.availableUser = true;
        $scope.availableEmail = true;
        $scope.incorrectUserPassword = false;

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
                        document.title = $scope.restaurantInfo.getName();
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

        $scope.saveRestaurantInfo = function () {
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 2, action: 3, JSONData: JSON.stringify($scope.restaurantInfo)});

            promise.then(function (data) {
                console.log(data);
                if (data[0] === true) {
                    if (angular.isString(data[1])) {
                        successMessage("Restaurant Info Updated");
                    }
                } else {

                    if (angular.isArray(data[1])) {
                        showErrors(data[1]);
                    } else {
                        showNormalError("An error occurred in the server, please come back later!");
                    }
                }
            });
        };





    });

    /**
     * Controller of the admin
     */
    restaurantApp.controller("adminController", function ($scope, accessService, $log, $http) {
        //Scope variables
        $scope.actionAdmin = 1;//Controls the action of the admin
        $scope.actionMenu = 1; //Cobtrols the action of the CRUD MENU
        $scope.actionTable = 1;//Controls the action of the CRUD TABLES
        $scope.resultDeleteImage = false;

        //Ingredients
        $scope.ingredients = []; //Array of ingredients
        $scope.newIngredient = new IngredientObj();
        $scope.hideButtonAdd = false;
        $scope.loadingIngredients = true;
        $scope.ingredientAux = new IngredientObj();
        $scope.menuItemCreation = true;
        $scope.ingredientsArrayAux = [];//Array auxiliar for ingredients with no pagination       

        //Restaurant
        $scope.equalPhoneNumbers = false;

        //Menu Items
        $scope.menuItems = [];
        $scope.menuItemsAux = [];
        $scope.newMenuItem = new MenuItemObj();
        $scope.loadingMenuItems = true;
        $scope.menuItemAux = new MenuItemObj();
        $scope.ingredientsNewMenuItem = [];
        $scope.modifiedIngredients = false;
        $scope.changeImage = false;

        //Courses 
        $scope.newCourse = new CourseObj();
        $scope.arrayCourseType = []; //an array of courses
        $scope.arrayCourseTypeAux = [];
        $scope.loadingCourses = true;
        $scope.hideButtonAddCourse = false;
        $scope.courseModify = new CourseObj();

        //Table Locations
        $scope.newTableLocation = new TableLocationObj();
        $scope.arrayTableLocations = []; //an array of table locations
        $scope.loadingTableLocations = true;
        $scope.hideButtonAddTableLocation = false;

        //Table Types
        $scope.newTableType = new TableTypeObj();
        $scope.arrayTableTypes = []; //an array of table types
        $scope.loadingTableTypes = true;
        $scope.hideButtonAddTableType = false;
        $scope.tableTypeModify = new TableTypeObj();

        //Table Status 
        $scope.tableStatus = new TableStatusObj();
        $scope.arrayTableStatus = [];
        $scope.tableLocation = new TableLocationObj();
        $scope.tableType = new TableTypeObj();

        //Tables
        $scope.newTable = new TableObj();
        $scope.arrayTables = [];
        $scope.hideButtonAddTable = false;
        $scope.loadingTables = true;
        $scope.tableModify = new TableObj();
        $scope.tableObj = new TableObj();

        //Menus
        $scope.newMenu = new MenuObj();
        $scope.newMenu.construct(0, "", 3, "Menu Description", 1);
        $scope.allMenus = [];
        $scope.menuItemsFiltered = [];
        $scope.loadingMenus = true;
        $scope.dataCourse = {};
        $scope.dataMenu = {};
        $scope.menuAux = new MenuObj();
        $scope.menuItemsModified = false;

        //Pagination
        $scope.pageSize = 5;
        $scope.currentPage = 1;



        //Methods
        $scope.deleteImage = function (imagePath) {

            if (imagePath !== null) {
                var promise = accessService.getData("php/controllers/MainController.php", false, "POST", {controllerType: 9, action: 280, JSONData: "", imageToDelete: imagePath});

                promise.then(function (data) {
                    $scope.resultDeleteImage = false;
                    if (data[0] === true) {
                        $scope.resultDeleteImage = true;
                    }
                });
            }

        };


        $scope.getMenus = function () {
            $scope.allMenus = [];
            $scope.loadingMenus = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10025, JSONData: JSON.stringify({none: ""})});

            promise.then(function (data) {
                $log.info(data);
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        //$log.info(data[1]);
                        //Iterate all the menus
                        $.each(data[1], function (index) {
                            var newMenu = new MenuObj();
                            newMenu.construct(data[1][index].menu_id, data[1][index].image, data[1][index].price, data[1][index].description, 1);
                            if (data[1][index].active == 0) {
                                newMenu.active = false;
                            } else {
                                newMenu.active = true;
                            }


                            //Iterate the items of the menu if there are items
                            if (typeof data[1][index].items !== 'undefined') {
                                $.each(data[1][index].items, function (i) {
                                    var menuItem = new MenuItemObj();
                                    var course = new CourseObj();
                                    course.construct(data[1][index].items[i].course_id, data[1][index].items[i].course_name, data[1][index].items[i].priority);
                                    menuItem.construct(data[1][index].items[i].item_id, course, data[1][index].items[i].item_name, data[1][index].items[i].item_image, data[1][index].items[i].item_price);
                                    newMenu.items.push(menuItem);
                                });
                            } else {
                                newMenu.items = [];
                            }

                            //Push the menu constructed
                            $scope.allMenus.push(newMenu);

                        });
                        $scope.loadingMenus = false;
                        $log.info($scope.allMenus);
                    } else {
                        errorGest("An error occured in the server, please try again later");
                    }

                    $("#imageMenu0").addClass("active");
                } else {
                    errorGest(data);
                }
            });
        };

        $scope.filterDataMenuItems = function () {
            $scope.menuItemsFiltered = [];

            //Filter the items
            $.each($scope.menuItemsAux, function (index, item) {
                if ($scope.dataCourse.courseTypeMenu.id === item.course.id) {
                    $scope.menuItemsFiltered.push(item);
                }
            });

            $scope.dataMenu.item = $scope.menuItemsFiltered[0];

        };

        $scope.addItemToMenu = function () {

            if ($scope.newMenu.items.length == 0) {
                $scope.newMenu.items.push($scope.dataMenu.item);
            } else {
                if ($scope.newMenu.items.indexOf($scope.dataMenu.item) == -1) {
                    $scope.newMenu.items.push($scope.dataMenu.item);
                } else {
                    alert("Item already added");
                }
            }

            //$log.info($scope.newMenu.items);
        };


        $scope.removeItemFromMenu = function (item) {
            var index = $scope.newMenu.items.indexOf(item);

            if (index !== -1) {
                $scope.newMenu.items.splice(index, 1);
            }

            //$log.info($scope.newMenu.items);
        };

        $scope.showFormAddNewMenu = function () {
            $scope.dataMenu = {};
            $scope.dataCourse = {};
            $("#buttonAddMenu").hide();
            $("#containerImageMenu").html("");
            $("#editImageMenu").val("");
            $("#divTableMenus").hide();
            $("#newMenuForm").toggle(800);
        };

        $scope.cancelNewMenu = function () {
            $("#newMenuForm").toggle(500);
            $("#buttonAddMenu").fadeIn(500);
            $scope.newMenu = new MenuObj();
        };


        $scope.addMenu = function () {
            //Get the image
            var imageFile = $("#editImageMenu")[0].files[0];
            var imagesArrayToSend = new FormData();
            imagesArrayToSend.append('images[]', imageFile);


            //Check if the image is putted in the input or not
            if ($("#editImageMenu")[0].files.length > 0) {
                //Upload the image first.
                //If the upload fails, don't upload the menu item info
                $http({
                    method: 'POST',
                    url: 'php/controllers/MainController.php?JSONData=""&controllerType=9&action=250&menu=1&imageName=' + $scope.newMenu.getDescription(),
                    headers: {'Content-Type': undefined},
                    data: imagesArrayToSend,
                    transformRequest: function (data, headersGetterFunction) {
                        return data;
                    }
                }).success(function (data) {
                    ////$log.info(data);
                    if (data[0] === true && angular.isString(data[1])) {
                        $scope.newMenu.setImage("images/menus/" + data[1]);
                        $scope.addMenuInfo();
                    } else {
                        errorGest(data);
                    }
                });

            } else {
                $scope.newMenu.setImage("images/menus/image.jpg");
                $scope.addMenuInfo();
            }

        };

        $scope.addMenuInfo = function () {
            //Insert menu item info
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10000, JSONData: angular.toJson($scope.newMenu)});


            promise.then(function (data) {
                if (data[0] === true) {//Now, if the insert goes OK, we will insert the 
                    //Menu items into the menu has item table
                    //Before insert the menu items, we must put tghe ID of the menu item inserted
                    $scope.newMenu.setMenuId(data[1].menuId)
                    $scope.insertMenuItems();
                } else {
                    errorGest(data);
                }
            });
        };

        $scope.insertMenuItems = function () {
            //Insert menu item info
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10010, JSONData: angular.toJson($scope.newMenu)});


            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.equals($scope.newMenu.items.length, data[1])) {
                        $scope.cancelNewMenu();
                        $scope.getMenus();
                        successMessage("Menu created successfully! ");
                    } else {
                        errorGest("There has been an error inserting the items of the menu, try it later.");
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        $scope.managementMenuActive = function (menu) {
            if (menu.active !== false) {
                menu.active = 0;
            } else {
                menu.active = 1;
            }

            //Send the new value to the server
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10015, JSONData: angular.toJson(menu)});

            promise.then(function (data) {
                if (data[0] !== true) {
                    errorGest(data);
                }
            });
        };

        this.modifyMenuForm = function (menu) {
            $scope.menuItemsModified = false;
            $scope.menuAux = angular.copy(menu);
            $scope.dataMenu = {};
            $scope.dataCourse = {};

            //Show modal
            $("#modifyMenuModal").modal({
                show: true,
                backdrop: false
            });

            $log.info($scope.menuAux);
        };

        $scope.closeModalMenu = function () {
            $("#modifyMenuModal").modal({
                show: false
            });

            $scope.getMenus();
        };

        $scope.addItemToMenuModify = function () {
            $scope.menuItemsModified = true;
            $scope.dataMenu = angular.copy($scope.dataMenu);

            if ($scope.menuAux.items.length == 0) {
                $scope.menuAux.items.push($scope.dataMenu.item);
            } else {
                var itemInArray = false;
                $.each($scope.menuAux.items, function (index, item) {
                    if (item.itemId == $scope.dataMenu.item.itemId) {
                        itemInArray = true;
                    }
                });

                if (itemInArray) {
                    alert("Item already added");
                } else {
                    $scope.menuAux.items.push($scope.dataMenu.item);
                }
            }
            $log.info($scope.menuAux.items);
        };

        $scope.removeItemFromMenuModify = function (item) {
            $scope.menuItemsModified = true;
            var index = $scope.menuAux.items.indexOf(item);

            if (index !== -1) {
                $scope.menuAux.items.splice(index, 1);
            }

            $log.info($scope.menuAux.items);
        };

        $scope.cancelImageModifyMenu = function () {
            $("#imageModifyMenu").val("");
            $scope.changeImage = false;
        };


        $scope.modifyMenu = function () {
            //Get the image
            var imageFile = $("#imageModifyMenu")[0].files[0];
            var imagesArrayToSend = new FormData();
            imagesArrayToSend.append('images[]', imageFile);

            //Check if the image is putted in the input or not
            if ($("#imageModifyMenu")[0].files.length > 0) {
                //Modify The Image of the menu
                //Upload the image first.
                //If the upload fails, don't upload the menu menu info
                $http({
                    method: 'POST',
                    url: 'php/controllers/MainController.php?JSONData=""&controllerType=9&menu=1&action=280&menu=' + angular.toJson($scope.menuAux),
                    headers: {'Content-Type': undefined},
                    data: imagesArrayToSend,
                    transformRequest: function (data, headersGetterFunction) {
                        return data;
                    }
                }).success(function (data) {
                    //$log.info(data);
                    if (data[0] === true && angular.isString(data[1])) {
                        $scope.menuAux.setImage("images/menus/" + data[1]);
                        $scope.updateInfoMenu();
                    } else {
                        errorGest(data);
                    }
                });

            } else {
                //Upload a menuItem without an image
                $scope.updateInfoMenu();
            }
        };

        $scope.updateInfoMenu = function () {
            if ($scope.menuAux.active) {
                $scope.menuAux.active = 1;
            } else {
                $scope.menuAux.active = 0;
            }

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10035, JSONData: angular.toJson($scope.menuAux)});

            promise.then(function (data) {
                if (data[0] === true) {//Menu info is modified correctly
                    if ($scope.menuItemsModified) {
                        $scope.updateMenuItemsFromMenu();
                    } else {
                        $("#modifyMenuModal").modal("hide");
                        successMessage("Menu modified Correctly");
                        $scope.getMenus();
                    }
                } else {
                    errorGest(data);
                }
            });

            $log.info($scope.menuAux);
        };


        $scope.updateMenuItemsFromMenu = function () {
            //First delete the items associated with the menu
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10070, JSONData: angular.toJson($scope.menuAux)});

            promise.then(function (data) {
                if (data[0] === true) {//If the delete goes OK, then push the new items of the menu
                    var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 10080, JSONData: angular.toJson($scope.menuAux)});

                    promise.then(function (data) {
                        if (data[0] === true) {
                            $("#modifyMenuModal").modal("hide");
                            successMessage("Menu modified Correctly");
                            $scope.getMenus();
                        } else {
                            errorGest(data);
                        }
                    });

                } else {
                    errorGest(data);
                }
            });
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

        /**
         * @name getCourseTypes
         * @description Gets the course Types from the server
         * @version 2
         * @author Victor Moreno García / Rifat Momin
         * @date 2016/05/17
         */
        $scope.getCourseTypes = function (pagination) {
            $scope.arrayCourseType = [];
            $scope.currentPage = 1;
            $scope.loadingCourses = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 6, action: 1, JSONData: JSON.stringify("")});
            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        //$log.info(data[1]);
                        $.each(data[1], function (i) {
                            var course = new CourseObj();
                            course.construct(data[1][i].course_id, data[1][i].course_name, data[1][i].priority);
                            if (pagination) {
                                $scope.arrayCourseType.push(course);
                            } else {
                                $scope.arrayCourseTypeAux.push(course);
                                $scope.newMenuItem.setCourse($scope.arrayCourseTypeAux[0]);
                            }

                        });

                        $scope.loadingCourses = false;
                        //$log.info($scope.arrayCourseType);
                    } else {
                        errorGest("Can't get the course types at this moment, try again later.");
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        /*
         * @description Inserts a new course to the db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/18 
         */
        $scope.addCourse = function () {
            $scope.newCourse = angular.copy($scope.newCourse);
            console.log($scope.newCourse);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 6, action: 2, JSONData: JSON.stringify($scope.newCourse)});

            promise.then(function (data) {
                if (data[0] === true) {
                    $scope.getCourseTypes(true);
                    successMessage("Course added");
                } else {
                    errorGest(data);
                }
            });
        }

        /*
         * @description Removes course from db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/18 
         */
        $scope.removeCourse = function (course) {
            //$log.info(idCourse);
            if (confirm("Are you sure you want to delete this course?")) {
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 6, action: 3, JSONData: angular.toJson(course)});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.getCourseTypes(true);
                        successMessage("Course Deleted");
                    } else {
                        errorGest(data);
                    }
                });
            }
        };

        /**
         * @name showAddNewCourseForm
         * @description Shows the form to add a new course
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/18
         */
        $scope.showAddNewCourseForm = function () {
            $("#buttonAddCourse").hide();
            $("#coursesForm").toggle(800);
        }

        /*
         * @name cancelNewCourse
         * @description Cleans and hides the add form
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/18
         */
        $scope.cancelNewCourse = function () {
            $("#coursesForm").toggle(500);
            $("#buttonAddCourse").fadeIn(500);
            $scope.newIngredient = new IngredientObj();
        };

        /*
         * @name editCourseForm
         * @description Shows course modification form
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/18
         */
        $scope.editCourseForm = function (course) {
            $scope.courseModify = angular.copy(course);

            $("#modifyCourseModal").modal("show");

        };

        /*
         * @name modifyCourse
         * @description Allows user to modify course info
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/18
         */
        $scope.modifyCourse = function (courseModify) {
            //console.log($scope.courseModify);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 6, action: 4, JSONData: JSON.stringify($scope.courseModify)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.getCourseTypes(true);
                        successMessage("Course Successfully Modified");
                        $("#modifyCourseModal").modal("hide");
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        /**
         * @name getIngredients
         * @description Gets the ingredients from the database
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.getIngredients = function (pagination) {
            $scope.currentPage = 1;
            $scope.ingredients = [];
            $scope.ingredientsArrayAux = [];
            $scope.loadingIngredients = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 1, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        //Control to prevent to show the pagination when loading the ingredients in
                        //Another template
                        if (!pagination) {
                            $.each(data[1], function (i) {
                                var newIngredient = new IngredientObj();
                                newIngredient.construct(data[1][i].ingredient_id, data[1][i].ingredient_name, data[1][i].price);
                                $scope.ingredientsArrayAux.push(newIngredient);
                            });

                            $scope.loadingIngredients = false;
                        } else {
                            $.each(data[1], function (i) {
                                var newIngredient = new IngredientObj();
                                newIngredient.construct(data[1][i].ingredient_id, data[1][i].ingredient_name, data[1][i].price);
                                $scope.ingredients.push(newIngredient);
                            });

                            $scope.loadingIngredients = false;
                        }

                    } else {
                        errorGest("Error getting info from Ingredients.");
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
        $scope.cancelNewIngredient = function () {
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
        $scope.addIngredient = function () {
            $scope.newIngredient = angular.copy($scope.newIngredient);

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 2, JSONData: JSON.stringify($scope.newIngredient)});

            promise.then(function (data) {
                if (data[0] === true) {
                    $scope.cancelNewIngredient();
                    $scope.getIngredients(true);
                    successMessage("Product Inserted correctly");
                } else {
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
         * @param idIngredient the  ingredient to remove
         */
        $scope.removeIngredient = function (ingredient) {
            //$log.info(idIngredient);
            if (confirm("Are you sure you want to delete this ingredient?")) {
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 3, JSONData: JSON.stringify({id: ingredient.getIngredientId()})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.getIngredients(true);
                        successMessage("Ingredient Deleted Correctly");
                    } else {
                        errorGest(data);
                    }
                });
            }
        };

        /**
         * @name editIngredientForm
         * @description Shows the modal to edit the ingredient
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         * @param ingredient to show in the form
         */
        $scope.editIngredientForm = function (ingredient) {
            $scope.ingredientAux = angular.copy(ingredient);

            $("#modifyIngredientModal").modal("show");

        };

        /**
         * @name modifyIngredient
         * @description updates the ingredient modified by the user.
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.modifyIngredient = function () {
            $scope.ingredientAux = angular.copy($scope.ingredientAux);

            //$log.info($scope.ingredientAux);

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 4, JSONData: JSON.stringify($scope.ingredientAux)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isString(data[1])) {
                        $("#modifyIngredientModal").modal("hide");
                    } else {
                        successMessage(data[2]);
                        $("#modifyIngredientModal").modal("hide");
                        $scope.getIngredients(true);
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        /**
         * @name getMenuItems
         * @description Gets the menu items from the database
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.getMenuItems = function (pagination) {
            $scope.currentPage = 1;
            $scope.menuItems = [];
            $scope.menuItemsAux = [];
            $scope.loadingMenuItems = true;
            $scope.menuItemCreation = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11100, JSONData: JSON.stringify({none: ""})});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $.each(data[1], function (i) {
                            var newMenuItem = new MenuItemObj();
                            var course = new CourseObj();
                            //Constructu the course object to put into the menu item
                            course.construct(data[1][i].course_id, data[1][i].course_name, data[1][i].priority);
                            //Constructu the main menu item
                            newMenuItem.construct(data[1][i].item_id, course, data[1][i].name, data[1][i].image, data[1][i].price);

                            //The ingredients are in a String separated by a semicolon
                            //We need to separate it with HTML format
                            var ingredientsMenuItem = [];
                            var ingredientsName = data[1][i].ingredient_name.split(";");
                            var ingredientsId = data[1][i].ingredient_id.split(";");
                            var ingredientsPrice = data[1][i].ingredient_price.split(";");

                            //Iterate all the ingredients in the object
                            $.each(ingredientsId, function (i) {
                                var ingredient = new IngredientObj();
                                ingredient.construct(ingredientsId[i], ingredientsName[i], ingredientsPrice[i]);
                                ingredientsMenuItem.push(ingredient);
                            });

                            newMenuItem.setIngredients(ingredientsMenuItem);

                            if (pagination) {
                                $scope.menuItems.push(newMenuItem);
                            } else {
                                $scope.menuItemsAux.push(newMenuItem);
                            }
                        });

                        $scope.loadingMenuItems = false;
                    } else {
                        errorGest("Sorry. There has been an error. Try again later or contact with us.");
                    }
                } else {
                    errorGest(data);
                }
            });

        };

        /**
         * @name showFromAddNewMenuItem
         * @description Shows the form to add a new Menu Item
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.showFormAddNewMenuItem = function () {
            $("#buttonAddMenuItem").hide();
            $("#newMenuItemForm").toggle(800);
            $("#divTableMenuItems").hide();
        };

        /**
         * @name cancelNewMenuItem
         * @description Cancels the new MenuItem creation putting the object to empty
         * and setting the default style
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/16
         */
        $scope.cancelNewMenuItem = function () {
            $("#newMenuItemForm").toggle(800);
            $("#buttonAddMenuItem").fadeIn(500);
            $("#containerImageMenuItem").html("");
            $("#editImageMenuItem").val("");
            $scope.newMenuItem = new MenuItemObj();
            $scope.newMenuItem.setCourse($scope.arrayCourseTypeAux[0]);
            $scope.ingredientsNewMenuItem = [];
            $('.ingredientCheckBox').prop('checked', false);
            $("#divTableMenuItems").fadeIn(500);
        };


        $scope.addMenuItem = function () {
            //Get the image
            var imageFile = $("#editImageMenuItem")[0].files[0];
            var imagesArrayToSend = new FormData();
            imagesArrayToSend.append('images[]', imageFile);


            //Check if the image is putted in the input or not
            if ($("#editImageMenuItem")[0].files.length > 0) {
                //New Menu item with image
                //Upload the image first.
                //If the upload fails, don't upload the menu item info
                $http({
                    method: 'POST',
                    url: 'php/controllers/MainController.php?JSONData=""&controllerType=9&action=250&menuItem=1&imageName=' + $scope.newMenuItem.getName(),
                    headers: {'Content-Type': undefined},
                    data: imagesArrayToSend,
                    transformRequest: function (data, headersGetterFunction) {
                        return data;
                    }
                }).success(function (data) {
                    ////$log.info(data);
                    if (data[0] === true && angular.isString(data[1])) {
                        $scope.addMenuItemInfo("images/menu_items/" + data[1]);
                    } else {
                        errorGest(data);
                    }
                });

            } else {
                //New Menu Item without an image
                $scope.addMenuItemInfo("images/menu_items/image.jpg");
            }
        };

        $scope.addMenuItemInfo = function (image) {
            //New Menu Item without an image
            //Set image default
            $scope.newMenuItem.setImage(image);

            //Clear the scopes to send it to the server
            $scope.newMenuItem = angular.copy($scope.newMenuItem);
            $scope.ingredientsNewMenuItem = angular.copy($scope.ingredientsNewMenuItem);

            //Sent the menuItem
            var promise = accessService.getData("php/controllers/MainController.php", false, "POST", {controllerType: 3, action: 11000, JSONData: angular.toJson($scope.newMenuItem)});

            promise.then(function (data) {
                //$log.info(data);
                if (data[0] === true) {//If menu item inserted, insert his ingredients
                    $scope.newMenuItem.setItemId(data['menuItemId']);
                    $scope.addMenuItemIngredients();
                } else {
                    errorGest(data);
                }
            });
        };


        $scope.addMenuItemIngredients = function (menuItemId) {
            //Now insert the ingredients that correspond to the menu item
            var promiseIngreidents = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 5, JSONData: angular.toJson($scope.newMenuItem)});
            promiseIngreidents.then(function (dataIngredients) {
                if (dataIngredients[0] === true) {
                    //$log.info(dataIngredients);
                    if (dataIngredients[1] == $scope.newMenuItem.ingredients.length) {
                        $scope.cancelNewMenuItem();
                        successMessage("Menu Item created Successfully");
                        $scope.getMenuItems(true);
                    } else {
                        errorGest(dataIngredients);
                    }
                } else {
                    errorGest(dataIngredients);
                }
            });
        };

        $scope.managementMenuItemIngredients = function (index, ingredient) {
            if ($("#ingredientMenuItem" + index).is(":checked")) {
                $scope.newMenuItem.getIngredients().push(ingredient);
            } else {
                var indexOf = $scope.newMenuItem.getIngredients().indexOf(ingredient);

                if (indexOf >= 0) {
                    $scope.newMenuItem.getIngredients().splice(indexOf, 1);
                }
            }

            //$log.info($scope.newMenuItem.getIngredients());
        };

        $scope.removeMenuItem = function (menuItem) {
            if (confirm("You want to delete the Menu Item <strong>" + menuItem.getName() + "</strong>")) {
                var item_id = angular.copy(menuItem.getItemId());
                //First check that the menu item isn't in a Menu
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11400, JSONData: JSON.stringify({menuItemId: item_id})});

                promise.then(function (data) {
                    if (data[0] === false) {//The item doesn't exists in a menu
                        //So we delete the ingredients for the menu item in the table Menu Item Has Ingredient
                        var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11500, JSONData: JSON.stringify({menuItemId: item_id})});

                        promise.then(function (data) {
                            if (data[0] === true) {//All the ingredients have been deleted from the table Menu Item Has Ingredient
                                //Now delete the menu items from the main table Menu Items
                                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11300, JSONData: JSON.stringify({menuItemId: item_id})});

                                promise.then(function (data) {
                                    if (data[0] === true) {//The menu item has deleted correctly from the DB
                                        //Now delete the image of the menu item
                                        $scope.deleteImage(menuItem.getImage());
                                        successMessage(data[1]);//We show the message from the server
                                        $scope.getMenuItems(true);
                                    } else {
                                        errorGest(data);
                                    }
                                });
                            } else {
                                errorGest(data);
                            }
                        });
                    } else {//The item exists in a menu
                        errorGest(data);
                    }
                });
            }
        };

        /**
         * @name editMenutItemForm
         * @description Shows the modal to edit the menu item
         * @version 1
         * @author Victor Moreno García
         * @date 2016/05/19
         * @param menuItem to show in the form
         */
        $scope.editMenutItemForm = function (menuItem) {
            $scope.getIngredients(false);
            $scope.menuItemAux = angular.copy(menuItem);
            $("#imageModifyMenuItem").val("");
            $scope.changeImage = false;
            $("#modifyMenuItemModal").modal({
                show: true,
                backdrop: false
            });

        };

        $scope.cancelModalMenuItem = function () {
            $("#modifyMenuItemModal").modal({
                show: false
            });
            $scope.getMenuItems(true);
        };

        $scope.hidePreviousImage = function (element) {
            $scope.$apply(function ($scope) {
                $scope.changeImage = true;
            });
        };

        $scope.cancelImageModifyItem = function () {
            $("#imageModifyMenuItem").val("");
            $scope.changeImage = false;
        };

        $scope.checkIngredientMenu = function (ing) {
            var foundIngredient = false;

            $.each($scope.menuItemAux.getIngredients(), function (i, ingredient) {
                if (angular.equals(ingredient, ing)) {
                    foundIngredient = true;
                }
            });

            return foundIngredient;
        };

        $scope.modifyMenuItem = function () {
            //Get the image
            var imageFile = $("#imageModifyMenuItem")[0].files[0];
            var imagesArrayToSend = new FormData();
            imagesArrayToSend.append('images[]', imageFile);

            //Check if the image is putted in the input or not
            if ($("#imageModifyMenuItem")[0].files.length > 0) {
                //Modify The Image of the menu item
                //Upload the image first.
                //If the upload fails, don't upload the menu item info
                $http({
                    method: 'POST',
                    url: 'php/controllers/MainController.php?JSONData=""&controllerType=9&menuItem=1&action=270&item=' + angular.toJson($scope.menuItemAux),
                    headers: {'Content-Type': undefined},
                    data: imagesArrayToSend,
                    transformRequest: function (data, headersGetterFunction) {
                        return data;
                    }
                }).success(function (data) {
                    //$log.info(data);
                    if (data[0] === true && angular.isString(data[1])) {
                        $scope.menuItemAux.setImage("images/menu_items/" + data[1]);
                        $scope.updateInfoMenuItem();
                    } else {
                        errorGest(data);
                    }
                });

            } else {
                //Upload a menuItem without an image
                $scope.updateInfoMenuItem();
            }


        };


        $scope.updateInfoMenuItem = function () {
            $scope.menuItemAux = angular.copy($scope.menuItemAux);

            //First update the menu item in the database
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11200, JSONData: JSON.stringify($scope.menuItemAux)});

            promise.then(function (data) {
                if (data[0] === true) {
                    //If the menu item is correctly updated, then update the ingredients from 
                    //the table menu item has ingredient if they are modified
                    if ($scope.modifiedIngredients) {
                        $scope.modifyIngredientsMenuItem();
                    } else {
                        successMessage("Menu Item Update correctly.");
                        $("#modifyMenuItemModal").modal("hide");
                        $scope.getMenuItems(true);
                    }
                } else {
                    errorGest();
                }
            });
        };


        $scope.modifyIngredientsMenuItem = function () {
            //First we delete the ingredients from the table menu item has ingredient
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11500, JSONData: JSON.stringify({menuItemId: $scope.menuItemAux.getItemId()})});

            promise.then(function (data) {
                if (data[0] === true) {//All the ingredients have been deleted from the table Menu Item Has Ingredient
                    //Now we insert the new ingredients for the menuItem
                    var promiseIngreidents = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 5, JSONData: angular.toJson($scope.menuItemAux)});
                    promiseIngreidents.then(function (dataIngredients) {
                        if (dataIngredients[0] === true) {
                            ////$log.info(dataIngredients);
                            if (dataIngredients[1] == $scope.menuItemAux.ingredients.length) {
                                successMessage("Menu Item Updated Successfully");
                                $("#modifyMenuItemModal").modal("hide");
                                $scope.getMenuItems(true);
                            } else {
                                errorGest(dataIngredients);
                            }
                        } else {
                            errorGest(dataIngredients);
                        }
                    });
                } else {
                    errorGest(data);
                }
            });

        };



        $scope.managementModifyIngredients = function (ingredient, index) {
            $scope.modifiedIngredients = true;
            if ($("#ingredientMenuItemModify" + index).is(":checked")) {
                $scope.menuItemAux.ingredients.push(ingredient);
            } else {
                $.each($scope.menuItemAux.ingredients, function (i, ing) {
                    if (angular.equals(ing, ingredient)) {
                        $scope.menuItemAux.ingredients.splice(i, 1);
                    }
                });
            }
            //$log.info($scope.menuItemAux.ingredients);
        };


        //TABLE LOCATIONS
        /**
         * @name getTableLocations
         * @description Gets the table locations from db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/19
         */
        $scope.getTableLocations = function () {
            $scope.currentPage = 1;
            $scope.arrayTableLocations = [];
            $scope.loadingTableLocations = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 1, JSONData: JSON.stringify("")});

            //console.log($scope.arrayTableLocations);
            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.arrayTableLocations = angular.copy(data[1]);
                        $scope.loadingTableLocations = false;
                    }
                } else {
                    errorGest(data);
                }
            });

        };

        /*
         * @name addTableLocation
         * @description Inserts a table location to the db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/19 
         */
        $scope.addTableLocation = function () {
            $scope.newTableLocation = angular.copy($scope.newTableLocation);
            console.log($scope.newTableLocation);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 2, JSONData: JSON.stringify($scope.newTableLocation)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        //$scope.cancelCourse();
                        //$scope.getCourseTypes();
                        successMessage("Table Location successfully added");

                        $("#buttonAddTableLocation").show();
                        $("#tableLocationsForm").hide();
                        $("tableLocationsForm").$setPristine();
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        /*
         * @name removeTableLocation
         * @description Removes table location from db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/19
         */
        $scope.removeTableLocation = function (tableLocationModify) {
            //$log.info(idCourse);
            if (confirm("Are you sure you want to delete this table location?")) {
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 3, JSONData: JSON.stringify({id: tableLocationModify})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        //$scope.getTableLocations();
                        successMessage("Table Location Deleted");
                    } else {
                        errorGest(data);
                    }
                });
            }
        };

        /*
         * @name modifyTableLocation
         * @description Allows user to modify table location name
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/19
         */
        $scope.modifyTableLocation = function (tableLocationModify) {
            //console.log($scope.courseModify);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 4, JSONData: JSON.stringify($scope.tableLocationModify)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        successMessage("Table Location Successfully Modified");
                        $("#modifyTableLocationModal").modal("hide");
                    }
                } else {
                    errorGest(data);
                }
            });
        };


        /**
         * @name showAddNewTableLocationForm
         * @description Shows the form when 
         * the button is clicked
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/19
         */
        $scope.showAddNewTableLocationForm = function () {
            $("#buttonAddTableLocation").hide();
            $("#tableLocationsForm").toggle(800);
        };

        /*
         * @name cancelNewTableLocation
         * @description Cleans and hides the add form
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/18
         */
        $scope.cancelNewTableLocation = function () {
            $("#tableLocationsForm").toggle(500);
            $("#buttonAddTableLocation").fadeIn(500);
            $scope.newTableLocation = new TableLocationObj();
        };

        /*
         * @name editTableLocationsForm
         * @description Shows table locations modification form
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/19
         */
        $scope.editTableLocationsForm = function (tableLocationModify) {
            $scope.tableLocationModify = angular.copy(tableLocationModify);
            $("#modifyTableLocationsModal").modal("show");

        };

        //TABLE TYPES CRUD
        /**
         * @name showAddNewTableTypeForm
         * @description Shows the form when 
         * the button is clicked
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/20
         */
        $scope.showAddNewTableTypeForm = function () {
            $("#buttonAddTableType").hide();
            $("#tableTypesForm").toggle(800);
        };

        /*
         * @name cancelNewTableTypes
         * @description Cleans and hides the add form
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/20
         */
        $scope.cancelNewTableType = function () {
            $("#tableTypesForm").toggle(500);
            $("#buttonAddTableType").fadeIn(500);
            $scope.newTablenewTableType = new TableTypeObj();
        };

        /**
         * @name getTableTypes
         * @description Gets the table types from db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/20
         */
        $scope.getTableTypes = function () {
            $scope.currentPage = 1;
            $scope.arrayTableTypes = [];
            $scope.loadingTableTypes = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 5, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.arrayTableTypes = angular.copy(data[1]);
                        $scope.loadingTableTypes = false;
                    }
                } else {
                    errorGest(data);
                }
            });

        };

        /*
         * @name addTableType
         * @description Inserts a new table type to the db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/20
         */
        $scope.addTableType = function () {
            $scope.newTableType = angular.copy($scope.newTableType);
            console.log($scope.newTableType);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 6, JSONData: JSON.stringify($scope.newTableType)});

            promise.then(function (data) {
                if (data[0] === true) {

                    $scope.getTableTypes();
                    successMessage("Table Type added");

                    $("#buttonAddTableType").show();
                    $("#tableTypesForm").hide();


                } else {
                    errorGest(data);
                }
            });
        };

        /*
         * @name editTableTypesForm
         * @description Shows table types modification form
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/20
         */
        $scope.editTableTypesForm = function (tableTypeModify) {
            $scope.tableTypeModify = angular.copy(tableTypeModify);
            $("#modifyTableTypesModal").modal("show");

        };

        /*
         * @name modifyTableType
         * @description Allows user to modify table type name
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/19
         */
        $scope.modifyTableType = function (tableTypeModify) {
            //console.log($scope.courseModify);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 8, JSONData: JSON.stringify($scope.tableTypeModify)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        successMessage("Table Type Successfully Modified");
                        $("#modifyTableTypesModal").modal("hide");
                    }
                } else {
                    errorGest(data);
                }
            });
        };

        /*
         * @name removeTableType
         * @description Removes table type from db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/20
         */
        $scope.removeTableType = function (tableId) {
            //$log.info(idCourse);
            if (confirm("Are you sure you want to delete this table type?")) {
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 7, JSONData: JSON.stringify({id: tableId})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.getIngredients();
                        successMessage("Table Type Deleted");
                    } else {
                        errorGest(data);
                    }
                });
            }
        };

        //TABLE STATUS

        /**
         * @name getTableStatus
         * @description Gets the table status from db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/23
         */
        $scope.getTableStatus = function () {
            $scope.arrayTableStatus = [];

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 13, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.arrayTableStatus = angular.copy(data[1]);

                    }
                } else {
                    errorGest(data);
                }
            });

        };


        //TABLES

        $scope.getTables = function () {
            $scope.currentPage = 1;
            $scope.arrayTables = [];
            $scope.loadingTables = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 9, JSONData: JSON.stringify({none: ""})});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $.each(data[1], function (index) {
                            var newTable = new TableObj();

                            $scope.tableLocation = new TableLocationObj();
                            $scope.tableLocation.construct(data[1][index].location_id, data[1][index].name_location);

                            $scope.tableType = new TableTypeObj();
                            $scope.tableType.construct(data[1][index].type_id, data[1][index].name_type);

                            $scope.tableStatus = new TableStatusObj();
                            $scope.tableStatus.construct(data[1][index].table_status_id, data[1][index].name_status);

                            newTable.construct(data[1][index].table_id, $scope.tableType, $scope.tableStatus, $scope.tableLocation, data[1][index].capacity);
                            $scope.arrayTables.push(newTable);
                            //console.log($scope.arrayTables);
                        });

                        //$log.info($scope.menuItems);
                        $scope.loadingTables = false;
                    } else {
                        errorGest("Sorry. There has been an error. Try again later or contact with us.");
                    }
                } else {
                    errorGest(data);
                }
            });

        };

        /**
         * @name showFormAddNewTable
         * @description Shows the form when 
         * the button is clicked
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/23
         */
        $scope.showFormAddNewTable = function () {
            $("#buttonAddTable").hide();
            $("#newTableForm").toggle(800);
        };

        /**
         * @name cancelNewTable
         * @description cancels the new table input
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/23
         */
        $scope.cancelNewTable = function () {
            $("#newTableForm").toggle(500);
            $("#buttonAddTable").fadeIn(500);
            $scope.newTable = new TableObj();
        };

        /*
         * @name editTableForm
         * @description Shows table modification form
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/23
         */
        $scope.editTableForm = function (table) {
            $scope.tableTypeModify = angular.copy(table);
            $("#modifyTablesModal").modal("show");

        };

        /*
         * @name addTable
         * @description Inserts a new table to the db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/23
         */
        $scope.addTable = function () {

            $scope.newTable = angular.copy($scope.newTable);
            $scope.tablesArray = [$scope.newTable.type_id, $scope.newTable.table_status, $scope.newTable.table_location, $scope.newTable.capacity];
            console.log($scope.tablesArray);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 10, JSONData: JSON.stringify($scope.tablesArray)});

            promise.then(function (data) {
                if (data[0] === true) {
                    console.log($scope.newTable);
                    $scope.getTables();
                    successMessage("Table added");

                    $("#buttonAddTable").show();
                    $("#newTableForm").hide();


                } else {
                    errorGest(data);
                }
            });
        };

        /*
         * @name removeTable
         * @description Removes table from db
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/23
         */
        $scope.removeTable = function (tableId) {

            if (confirm("Are you sure you want to delete this table?")) {
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 11, JSONData: JSON.stringify({id: tableId})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.getTables();
                        successMessage("Table Successfully Deleted");
                    } else {
                        errorGest(data);
                    }
                });
            }
        };

        /*
         * @name modifyTable
         * @description Allows user to modify table info
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/23
         */
        $scope.modifyTable = function (tableModify) {
            //console.log($scope.courseModify);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 7, action: 12, JSONData: JSON.stringify($scope.tableModify)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.getTables();
                        successMessage("Table Successfully Modified");
                        $("#modifyTablesModal").modal("hide");
                    }
                } else {
                    errorGest(data);
                }
            });
        };




    });

    restaurantApp.controller("customerController", function ($scope, accessService, $log, $http) {
        //Scope variables to control the flow of the page
        $scope.actionCustomer = 1;

    });


    /*
     * ***** TEMPLATES *****
     * 
     * The templates are used to display different contents on the page
     * without change the location of the URL
     */
    restaurantApp.directive("tableTables", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDTables/tableTables.html",
            controller: function () {
            },
            controllerAs: 'tableTables'
        };
    });

    restaurantApp.directive("tableTableTypes", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDTables/tableTableTypes.html",
            controller: function () {
            },
            controllerAs: 'tableTableTypes'
        };
    });

    restaurantApp.directive("tableTableLocations", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDTables/tableTableLocations.html",
            controller: function () {
            },
            controllerAs: 'tableTableLocations'
        };
    });

    restaurantApp.directive("tablesTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDTables/tablesTemplate.html",
            controller: function () {
            },
            controllerAs: 'tablesTemplate'
        };
    });

    restaurantApp.directive("coursesTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDCourses/coursesTemplate.html",
            controller: function () {
            },
            controllerAs: 'coursesTemplate'
        };
    });

    restaurantApp.directive("tableMenuItems", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDMenus/tableMenuItems.html",
            controller: function () {
            },
            controllerAs: 'tableMenuItems'
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

    restaurantApp.directive("customerTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Customer/customerTemplate.html",
            controller: function () {
            },
            controllerAs: 'customerTemplate'
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

    restaurantApp.directive("restaurantInfoTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Admin/CRUDRestaurant/restaurantInfoTemplate.html",
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

    //CUSTOMER TEMPLATES
    restaurantApp.directive("makeOrderTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Customer/makeOrderTemplate.html",
            controller: function () {

            },
            controllerAs: 'makeOrderTemplate'
        };

    });
    
    restaurantApp.directive("orderHistoricTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Customer/orderHistoricTemplate.html",
            controller: function () {

            },
            controllerAs: 'orderHistoricTemplate'
        };

    });
    
    restaurantApp.directive("viewReviewsTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/Customer/viewReviewsTemplate.html",
            controller: function () {

            },
            controllerAs: 'viewReviewsTemplate'
        };

    });


    restaurantApp.factory('accessService', function ($http, $log, $q) {
        return {
            getData: function (url, async, method, params, data) {
                var deferred = $q.defer();
                $http({
                    url: url,
                    method: method,
                    async: async,
                    params: params,
                    data: data
                })
                        .success(function (response, status, headers, config) {
                            deferred.resolve(response);
                        })
                        .error(function (msg, code) {
                            deferred.reject(msg);
                            $log.error(msg, code);
                            //alert("There has been an error in the server, try later");
                        });

                return deferred.promise;
            }
        };
    });


})();

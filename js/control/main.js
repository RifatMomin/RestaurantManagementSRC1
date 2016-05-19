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
                    alert("Restaurant information updated");
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
    restaurantApp.controller("adminController", function ($scope, accessService, $log) {
        //Scope variables
        $scope.actionAdmin = 1;//Controls the action of the admin
        $scope.actionMenu = 2; //Cobtrols the action of the CRUD MENU
        $scope.arrayCourseType = [];

        //Ingredients
        $scope.ingredients = []; //Array of ingredients
        $scope.newIngredient = new IngredientObj();
        $scope.hideButtonAdd = false;
        $scope.loadingIngredients = true;
        $scope.ingredientAux = new IngredientObj();
        $scope.menuItemCreation = true;

        //Restaurant
        $scope.equalPhoneNumbers = false;

        //Menu Items
        $scope.menuItems = [];
        $scope.newMenuItem = new MenuItemObj();
        $scope.loadingMenuItems = false;
        $scope.menuItemAux = new MenuItemObj();
        $scope.ingredientsNewMenuItem = [];

        //Courses 
        $scope.newCourse = new CourseObj();
        $scope.arrayCourseType = []; //an array of courses
        $scope.loadingCourses = true;
        $scope.hideButtonAddCourse = false;
        $scope.courseModify = new CourseObj();
        
        
        //Pagination
        $scope.pageSize = 5;
        $scope.currentPage = 1;


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
        $scope.getCourseTypes = function () {
            $scope.arrayCourseType = [];
            $scope.currentPage= 1;
            $scope.loadingCourses = true;
            
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 6, action: 1, JSONData: JSON.stringify("")});
            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.arrayCourseType = angular.copy(data[1]);
                        $scope.newMenuItem.courseId = data[1][0];
                        $scope.loadingCourses = false;
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
                    //$scope.cancelCourse();
                    $scope.getCourseTypes();
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
        $scope.removeCourse = function (idCourse) {
            //$log.info(idCourse);
            if (confirm("Are you sure you want to delete this course?")) {
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 6, action: 3, JSONData: JSON.stringify({id: idCourse})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.getIngredients();
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
        $scope.modifyCourse = function (courseModify){
            //console.log($scope.courseModify);
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 6, action: 4, JSONData: JSON.stringify($scope.courseModify)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
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
        $scope.getIngredients = function () {
            $scope.currentPage = 1;
            $scope.ingredients = [];
            $scope.loadingIngredients = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 1, JSONData: JSON.stringify("")});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $scope.ingredients = angular.copy(data[1]);

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
                    $scope.getIngredients();
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
         */
        $scope.removeIngredient = function (idIngredient) {
            //$log.info(idIngredient);
            if (confirm("Are you sure you want to delete this ingredient?")) {
                var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 3, JSONData: JSON.stringify({id: idIngredient})});

                promise.then(function (data) {
                    if (data[0] === true) {
                        $scope.getIngredients();
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

            $log.info($scope.ingredientAux);

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 4, JSONData: JSON.stringify($scope.ingredientAux)});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isString(data[1])) {
                        $("#modifyIngredientModal").modal("hide");
                    } else {
                        successMessage(data[2]);
                        $("#modifyIngredientModal").modal("hide");
                        $scope.getIngredients();
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
        $scope.getMenuItems = function () {
            $scope.currentPage = 1;
            $scope.menuItems = [];
            $scope.loadingMenuItems = true;
            $scope.menuItemCreation = true;

            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11100, JSONData: JSON.stringify({none: ""})});

            promise.then(function (data) {
                if (data[0] === true) {
                    if (angular.isArray(data[1])) {
                        $.each(data[1], function (index) {
                            //The ingredients are in a String separated by a semicolon
                            //We need to separate it with HTML format
                            data[1][index].ingredients = data[1][index].ingredients.split(";");

                            $scope.menuItems.push(data[1][index]);
                        });

                        //$log.info($scope.menuItems);
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
         * @name showFromAddNewMenu Item
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
            $scope.newMenuItem = new MenuItemObj();
            $scope.newMenuItem.setCourseId($scope.arrayCourseType[0]);
            $scope.ingredientsNewMenuItem = [];
            $('.ingredientCheckBox').prop('checked', false);
            $("#divTableMenuItems").fadeIn(500);
        };


        $scope.addMenuItem = function () {
            //New Menu Item without an image
            //Set image default
            $scope.newMenuItem.setImage("images/menu_items/image.jpg");
            $scope.newMenuItem.setCourseId($scope.newMenuItem.getCourseId().course_id);

            //Clear the scopes to send it to the server
            $scope.newMenuItem = angular.copy($scope.newMenuItem);
            $scope.ingredientsNewMenuItem = angular.copy($scope.ingredientsNewMenuItem);

            //Sent the menuItem
            var promise = accessService.getData("php/controllers/MainController.php", false, "POST", {controllerType: 3, action: 11000, JSONData: JSON.stringify({menuItem: $scope.newMenuItem})});

            promise.then(function (data) {
                if (data[0] === true) {//If menu item inserted, insert his ingredients
                    var menuItemId = data['menuItemId'];
                    $scope.addMenuItemIngredients(menuItemId);
                } else {
                    errorGest(data);
                }
            });
        };

        $scope.addMenuItemIngredients = function (menuItemId) {
            //Now insert the ingredients that correspond to the menu item
            var promiseIngreidents = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 5, action: 5, JSONData: JSON.stringify({ingredients: $scope.ingredientsNewMenuItem, menuItemId: menuItemId})});
            promiseIngreidents.then(function (dataIngredients) {
                if (dataIngredients[0] === true) {
                    $log.info(dataIngredients);
                    if (dataIngredients[1] == $scope.ingredientsNewMenuItem.length) {
                        $scope.cancelNewMenuItem();
                        successMessage("Menu Item created Successfully");
                        $scope.getMenuItems();
                    }
                } else {
                    errorGest(dataIngredients);
                }
            });
        };

        $scope.managementMenuItemIngredients = function (index, ingredient) {
            if ($("#ingredientMenuItem" + index).is(":checked")) {
                $scope.ingredientsNewMenuItem.push(ingredient);
            } else {
                $.each($scope.ingredientsNewMenuItem, function (i) {
                    if (angular.equals($scope.ingredientsNewMenuItem[i], ingredient)) {
                        $scope.ingredientsNewMenuItem.splice(i, 1);
                    }
                });
            }

            $log.info($scope.ingredientsNewMenuItem);
        };

        $scope.removeMenuItem = function (menuItem) {
            var item_id = angular.copy(menuItem.item_id);
            //First check that the menu item isn't in a Menu
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11400, JSONData: JSON.stringify({menuItemId: item_id})});

            promise.then(function (data) {
                if (data[0] === false) {//The item doesn't exists in a menu
                    //So we delete the menu items
                    var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11300, JSONData: JSON.stringify({menuItemId: item_id})});

                    promise.then(function (data) {
                        $log.info(data);
                    });
                } else {//The item exists in a menu
                   errorGest(data);
                }
            });


//            var promise  = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 3, action: 11300, JSONData: JSON.stringify({menuItemId: item_id})});
//        
//            promise.then(function(data){
//                $log.info(data);
//            });
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
                            alert("There has been an error in the server, try later");
                        });

                return deferred.promise;
            }
        };
    });

})();
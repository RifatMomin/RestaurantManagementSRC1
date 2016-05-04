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
    var mainApp = angular.module("mainRestaurantApp", []);

    mainApp.controller("sessionController", function ($http, $scope, accessService, $log) {

        //scope variables
        $scope.user = new UserObj();
        $scope.usernameValid = true;
        $scope.passwordValid = true;

        this.sessionControl = function ()
        {
            if (typeof (Storage) == "undefined")
            {
                alert("Your browser is not compatible with sessions, upgrade your browser");
            } else
            {
                if (sessionStorage.length > 0)
                {
                    var objAux = JSON.parse(sessionStorage.getItem("connectedUser"));

                    var user = new userObj();
                    user.construct(objAux.id, objAux.name, objAux.surname1, objAux.nick, objAux.password, objAux.address, objAux.telephone, objAux.mail, objAux.birthDate, objAux.entryDate, objAux.dropOutDate, objAux.active, objAux.image);

                    if (!isNaN(user.getId()))
                    {
                        window.open("mainWindow.html", "_self");
                    }
                }

                var promise = accessService.getData("MainController", true, "POST", {controllerType: 0, action: 10400, JSONData: {none: ""}});

                promise.then(function (outPutData) {
                    if (outPutData[0] === true)
                    {
                        /*
                         var user = new userObj();
                         user.construct(outPutData[1].id, outPutData[1].name, outPutData[1].surname1, outPutData[1].nick, outPutData[1].password, outPutData[1].address, outPutData[1].telephone, outPutData[1].mail, outPutData[1].birthDate, outPutData[1].entryDate, outPutData[1].dropOutDate, outPutData[1].active, outPutData[1].image);
                         */
                        if (typeof (Storage) == "undefined")
                        {
                            alert("Your browser is not compatible with sessions, upgrade your browser");
                        } else
                        {
                            console.log(user);

                            $scope.userManag = 0;

                            sessionStorage.setItem("connectedUser", JSON.stringify(outPutData[1]));

                            window.open("mainWindow.html", "_self");
                        }

                    }
                });
            }
        }

        $scope.connection = function ()
        {
            //copy 
            $scope.user = angular.copy($scope.user);

            //Server conenction to verify user's data
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10010, JSONData: JSON.stringify($scope.user)});

            promise.then(function (outPutData) {
                console.log(outPutData);
                /*if (outPutData[0] === true)
                {
                    //We get users data
                    // In outPutData[1] we have an array of only one position
                    // outPutData[1][0] is a pseudo object
                    var user = new userObj();

                    user.construct(outPutData[1][0].id, outPutData[1][0].name, outPutData[1][0].surname1, outPutData[1][0].nick, outPutData[1][0].password, outPutData[1][0].address, outPutData[1][0].telephone, outPutData[1][0].mail, outPutData[1][0].birthDate, outPutData[1][0].entryDate, outPutData[1][0].dropOutDate, outPutData[1][0].active, outPutData[1][0].image);

                    if (typeof (Storage) == "undefined")
                    {
                        alert("Your browser is not compatible with sessions, upgrade your browser");
                    } else
                    {
                        console.log(user);

                        $scope.userManag = 0;

                        sessionStorage.setItem("connectedUser", JSON.stringify(user));

                        window.open("mainWindow.html", "_self");
                    }

                } else
                {
                    if (angular.isArray(outPutData[1]))
                    {
                        showErrors(outPutData[1]);
                    } else {
                        alert("There has been an error in the server, try later");
                    }
                }*/
            });
        }

        /*this.checkNick = function ()
        {
            var promise = accessService.getData("MainController", true, "POST", {controllerType: 0, action: 10300, JSONData: JSON.stringify({nick: $scope.user.getNick()})});

            promise.then(function (outPutData) {
                if (outPutData[0] === true)
                {
                    $scope.nickValid = false;
                    $("#userNick").removeClass("ng-valid").addClass("ng-invalid");

                } else
                {

                    if (angular.isArray(outPutData[1]))
                    {
                        $scope.nickValid = true;
                        $("#userNick").removeClass("ng-invalid").addClass("ng-valid");
                    } else {
                        alert("There has been an error in the server, try later");
                    }
                }
            });
        }*/



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

    //Templates
    mainApp.directive("contactTemplate", function () {
        return {
            restrict: 'E',
            templateUrl: "templates/contactTemplate.html",
            controller: function () {

            },
            controllerAs: 'contactTemplate'
        };
    });
    
    mainApp.factory('accessService', function($http, $log, $q) {
        return {
            getData: function(url, async, method, params, data) {
                var deferred = $q.defer();
                $http({
                    url: url, 
                    method: method,
                    asyn: async,
                    params: params,
                    data: data 
                })
                .success(function(response, status, headers, config)  {
                    deferred.resolve(response);						   
                })
                .error(function(msg, code) {
                    deferred.reject(msg);
                    $log.error(msg, code);
                    alert("There has been an error in the server, try later");
                });

                return deferred.promise;
            }
        };
    });
})();
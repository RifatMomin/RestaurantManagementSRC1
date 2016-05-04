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
       

        $scope.connection = function ()
        {
            //copy 
            $scope.user = angular.copy($scope.user);
            
            //Server conenction to verify user's data
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10010, JSONData: JSON.stringify($scope.user)});

            promise.then(function (data) {
                if(data[0]===true){
                    //Create local session
                    createLocalSession(data[1][0]);
                    
                    //alert("Welcome "+data[1][0].name+data[1][0].surname);
                   // window.open("main.html","_self");
                    
                }else{
                    if(angular.isArray(data[1])){
                        showErrors(data[1]);
                    }else{
                        showNormalError("An error occurred in the server, please come back later!");
                    }
                }        
            });
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
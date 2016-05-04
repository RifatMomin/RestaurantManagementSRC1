/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function () {
    var restaurantApp = angular.module("restaurantApp", []);

    restaurantApp.controller("mainController", function ($scope, $http, accessService) {
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


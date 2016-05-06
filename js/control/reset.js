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
    var mainApp = angular.module("RestaurantAppReset", []);

    mainApp.controller("resetController", function ($http, $scope, accessService) {
        
        //scope variables        
        $scope.user = new UserObj();
        $scope.password2;
        $scope.samePasswd=false;
        $scope.ObjectPasswordArray = new Array();
        
        /**
         * @description Shows the user to retrieve his password
         * @version 1
         * @author Rifat Momin
         * @date 2016/05/04
         */
        $scope.resetPassword = function (){
            $scope.user = angular.copy($scope.user);
            $scope.ObjectPasswordArray= [$scope.user, $scope.password2];
            
            //Server conenction to verify user's data
            var promise = accessService.getData("php/controllers/MainController.php", true, "POST", {controllerType: 0, action: 10300, JSONData: JSON.stringify($scope.ObjectPasswordArray)});
            
            promise.then(function (data) {
                if(data[0]===true){
                    window.open("index.php","_self"); 
                }else{
                    if(angular.isArray(data[1])){
                        showErrors(data[1]);
                    } else {
                        showNormalError("An error occurred in the server, please come back later!");
                    }
                }
            });
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
    
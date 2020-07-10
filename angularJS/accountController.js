(function () {
    var AccountController = function($scope, $http) {

        this.$onInit = function() {
            $http.post("/API/AccountAPI.php", {userId : userId}).then(function(response) {
                var data = response['data'];
                $scope.checkedOut = data['checkedOut'];
                $scope.onHold = data['onHold'];
                $scope.accountDetails = data["accountDetails"];
            })
        }

        $scope.active = 'checkedOutBooks';

        $scope.setActive = function(type) {
            $scope.active = type;
        };

        $scope.isActive = function(type) {
            return type === $scope.active;
        };

    };
    app.controller("AccountController", ["$scope", "$http", AccountController]);

    app.component('accountDetails', {
        templateUrl: 'angularJS/accountDetailsTemplate.html',
        bindings: {
            accountDetails: '<'
        }
    });
}());
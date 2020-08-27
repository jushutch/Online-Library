(function () {
    var app = angular.module("bookSearchModule", []);

    var BookDetailController = function($scope, $http) {
        var vm = this;
        var buttonOperation = null;

        const CHECK_OUT = "checkout";
        const PUT_ON_HOLD = "put_on_hold";
        vm.$onInit = function() {
            $scope.buttonDisabled = false;
            if (vm.book.isAvailable) {
                $scope.buttonText = "Check Out";
                buttonOperation = CHECK_OUT;

            } else {
                $scope.buttonText = "Put On Hold";
                buttonOperation = PUT_ON_HOLD;
            }
        }

        $scope.changeBookAvailable = function() {
            if (!userId) {
                window.location.href = "login.php";
            } else {
                $http.post("/API/CheckoutAPI.php",
                    {isbn : vm.book.isbn,
                        userId : userId,
                        action : buttonOperation})
                    .then(function(response) {
                        $scope.buttonText = "Success!";
                        $scope.buttonDisabled = true;
                        buttonOperation = null;
                    });
            }
        }

        $scope.checkOut = function() {
            if (!userId) {
                window.location.href = "login.php";
            } else {
                $http.post("/API/CheckoutAPI.php",
                    {isbn : vm.book.isbn,
                    userId : userId})
                    .then(function(response){
                        $scope.buttonText = "Success!";
                        $scope.checkoutDisabled = true;
                    });
            }
        }
    };

    var SearchController = function($scope, $http) {
        $scope.searchResults = [];
        $scope.hasSearchResults = false;
        $scope.carrySearchTerms = "";

        $scope.search = function(searchText) {
            $http({
                url: "/API/BookApi.php",
                method: "GET",
                params: {searchText : searchText}
            })
            .then(function(book){
                $scope.searchResults = book["data"];
                $scope.carrySearchTerms = searchText;
                $scope.hasSearchResults = true;
                console.log($scope.searchResults);
            });
        };

    };
    app.controller("SearchController", ["$scope", "$http", SearchController]);
    app.component('searchResult', {
        templateUrl: 'angularJS/searchResultTemplate.html',
        controller: BookDetailController,
        bindings: {
            book: '<'
        }
    });
}());
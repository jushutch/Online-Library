(function () {
    var app = angular.module("bookSearchModule", []);

    var BookDetailController = function($scope, $http) {
        var vm = this;
        vm.$onInit = function() {
            if (vm.book.isAvailable) {
                $scope.buttonText = "Check Out";
            } else {
                $scope.buttonText = "Unavailable";
                $scope.checkoutDisabled = true;
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
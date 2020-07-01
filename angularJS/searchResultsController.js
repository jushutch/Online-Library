(function () {
    var app = angular.module("bookModule", []);

    var MainController = function($scope, $http) {

        $scope.searchResults = [];
        $scope.hasSearchResult = false;

        $scope.search = function(searchText) {
            $http.post("/API/BookApi.php", {searchText: searchText}).then(function(book){
                $scope.searchResults = book["data"];
                $scope.hasSearchResult = true;
                console.log($scope.searchResults);
            });
        };

    };
    app.controller("MainController", ["$scope", "$http", MainController]);
    app.component('searchResult', {
        templateUrl: 'angularJs/searchResultTemplate.html',
        bindings: {
            book: '='
        }
    });
}());
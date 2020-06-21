(function () {
    var app = angular.module("bookSearch", []);

    var MainController = function($scope, $http) {

        $scope.searchResult = [];
        $scope.hasSearchResult = false;

        $scope.search = function(isbn) {
            $http({
                url: "https://www.googleapis.com/books/v1/volumes?",
                method: "GET",
                params: {q: "isbn:" + isbn,
                        key: "AIzaSyB-i-PPUNVpeDVlQeCd4_ABn8H60hs2VTE"}
            }).then(function(response){
                $scope.searchResult = response['data']['items'][0]['volumeInfo'];

                $scope.hasSearchResult = true;
                console.log($scope.searchResult);
            }).then(function() {
                $scope.pageCount = $scope.searchResult.pageCount;
                $scope.publishDate = $scope.searchResult.publishedDate;
                $scope.description = $scope.searchResult.description;
                $scope.title = $scope.searchResult.title;
                $scope.authors = $scope.searchResult.authors;
                $scope.isbn = isbn;
            });
        };

    };
    app.controller("MainController", ["$scope", "$http", MainController]);
}());
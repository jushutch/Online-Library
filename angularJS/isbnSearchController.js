(function () {
    var app = angular.module("ISBNSearch", []);

    var MainController = function($scope, $http) {

        $scope.searchResult = [];
        $scope.hasSearchResult = false;

        $scope.search = function(isbn) {
            $http.post("/API/ISBNApi.php", {isbn: isbn}).then(function(book){
                $scope.searchResult = book["data"];
                $scope.hasSearchResult = true;
                console.log($scope.searchResult);
            }).then(function() {
                $scope.isbn = isbn;
                if (!$scope.searchResult) return;
                if ("seriesNumber" in $scope.searchResult) $scope.seriesNumber = $scope.searchResult.seriesNumber;
                if ("subtitle" in $scope.searchResult) $scope.subtitle = $scope.searchResult.subtitle;
                if ("imageLinks" in $scope.searchResult && "thumbnail" in $scope.searchResult.imageLinks) $scope.imageURL = $scope.searchResult.imageLinks.thumbnail;
                $scope.publisher = $scope.searchResult.publisher;
                $scope.pageCount = $scope.searchResult.pageCount;
                $scope.publishDate = ($scope.searchResult.publishedDate).substring(0, 4);
                $scope.description = $scope.searchResult.description;
                $scope.title = $scope.searchResult.title;
                $scope.authors = $scope.searchResult.authors;
            });
        };

    };
    app.controller("MainController", ["$scope", "$http", MainController]);
}());
(function () {
    var AdminController = function($scope, $http) {
        const ACTION_DELETE = "delete";
        const ACTION_UPDATE = "update";
        const ACTION_CHECK_IN = "check_in";

        $scope.searchResult = [];
        $scope.hasSearchResult = false;

        $scope.search = function(isbn) {
            $http({
                url: "/API/BookAPI.php",
                method: "GET",
                params: {searchText: isbn}
            }).then(function(book) {
                if (!book) {
                    $http({
                        url: "/API/ISBNApi.php",
                        method: "GET",
                        params: {isbn : isbn}
                    })
                    .then(function(book){
                        $scope.searchResult = book["data"][0];
                        $scope.hasSearchResult = true;
                    })
                } else {
                    $scope.searchResult = book["data"][0];
                    $scope.hasSearchResult = true;
                    $scope.bookIsInLibrary = true;
                }
            });
        };

        $scope.deleteBook = function(book) {
            $http({
                url: "/API/ManageBookAPI.php",
                method: "POST",
                params: {book: $scope.searchResult, action: ACTION_DELETE}
            }).then(function(response) {
                    $scope.searchResult = null;
                    $scope.hasSearchResult = false;
                }
            )
        }

        $scope.checkInBook = function(book) {
            $http({
                url: "/API/ManageBookAPI.php",
                headers: {'Content-Type' : 'application/json'},
                method: "POST",
                params: {book: $scope.searchResult, action: ACTION_CHECK_IN}
            }).then(function(response) {
                    $scope.searchResult = null;
                    $scope.hasSearchResult = false;
                }
            )
        }

        $scope.updateBook = function(book) {
            $http({
                url: "/API/ManageBookAPI.php",
                method: "POST",
                params: {book: $scope.searchResult, action: ACTION_UPDATE}
            }).then(function(response) {
                    $scope.searchResult = null;
                    $scope.hasSearchResult = false;
                }
            )
        }

        // $scope.assignBookToScope = function(book) {
        //     if (!book) return;
        //     if ("seriesNumber" in book) $scope.seriesNumber = book.seriesNumber;
        //     if ("subtitle" in book) $scope.subtitle = book.subtitle;
        //     if ("imageLinks" in book && "thumbnail" in book.imageLinks) $scope.imageURL = book.imageLinks.thumbnail;
        //     $scope.publisher = book.publisher;
        //     $scope.pageCount = book.pageCount;
        //     $scope.publishDate = (book.year);
        //     $scope.description = book.description;
        //     $scope.title = book.title;
        //     $scope.authors = book.authors;
        // }

    };
    app.controller("AdminController", ["$scope", "$http", AdminController]);

    app.component('admin', {
        templateUrl: 'angularJS/adminTemplate.html',
        controller: AdminController
    });
}());
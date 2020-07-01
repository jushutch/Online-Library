<html ng-app="bookModule" lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script>
    <link rel="stylesheet" href="CSS/sharedStyles.css">
    <link rel="stylesheet" href="CSS/indexStyle.css">
    <link rel="stylesheet" href="CSS/searchResultStyle.css">
    <script src="angularJS/searchResultsController.js"></script>
<!--    <script src="searchResultsComponent.js"></script>-->
    <title>Library of Time</title>
</head>
<body  ng-controller="MainController">
    <div style="width:50%;margin:auto;padding:20px;">
        <form ng-submit="search(searchTerms)" class="search">
            <input type="text" ng-model="searchTerms" placeholder="Search Library" name="searchTerms" class="searchTerm" autocomplete="off" autofocus>
            <input type="submit" name="searchLibrary" value="Search" class="searchButton">
        </form>
    </div>
<!--    <div ng-repeat="book in searchResults">-->
<!--        <search-result book={{book}}></search-result>-->
<!--    </div>-->
    <div class="search_result" ng-repeat="book in searchResults">
        <search-result book="book"></search-result>
    </div>
<!--    <select name="searchField" required>-->
<!--        <option value="all" selected>All Fields</option>-->
<!--        <option value="title">Title</option>-->
<!--        <option value="author">Author</option>-->
<!--        <option value="publisher">Publisher</option>-->
<!--        <option value="series">Series</option>-->
<!--        <option value="description">Description</option>-->
<!--    </select>-->
</body>
</html>
<html ng-app="bookSearchModule" lang="en">
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
    <body  ng-controller="SearchController">
        <div ng-if="!hasSearchResults">
            <div id="searchBarWrapper">
                <div style="text-align:center;">
                    <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
                </div>
                <form ng-submit="search(searchTerms)" class="search">
                    <input type="text"  ng-model="searchTerms" placeholder="Search Library" name="searchTerms" class="searchTerm" autocomplete="off" autofocus>
                    <input type="submit" value="Search" name="searchLibrary" class="searchButton">
                </form>
            </div>
        </div>
        <div ng-if="hasSearchResults">
            <div  style="width:50%;margin:auto;padding:20px;">
                <form ng-submit="search(searchTerms)" class="search">
                    <input type="text" ng-model="searchTerms" ng-value="carrySearchTerms" placeholder="Search Library" name="searchTerms" class="searchTerm" autocomplete="off" autofocus>
                    <input type="submit" name="searchLibrary" value="Search" class="searchButton">
                </form>
            </div>
            <div class="search_result" ng-repeat="book in searchResults">
                <search-result book="book"></search-result>
            </div>
        </div>
    </body>
</html>
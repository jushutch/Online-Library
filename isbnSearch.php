<?php
    session_start();
    require_once "Book.php";

    if (!$_SESSION['admin'] || !$_SESSION['loggedIn']) {
        header("Location:login.php");
    }

?>
<html ng-app="bookSearch">
    <head>
        <title>Add Book</title>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script>
        <script src="isbnSearchComponent.js"></script>
        <link rel="stylesheet" href="sharedStyles.css">
        <link rel="stylesheet" href="formStyle.css">
    </head>
    <body ng-controller="MainController">
        <form autocomplete="off" ng-submit="search(isbn)" ng-if="!hasSearchResult">
            <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
            <ul class="formList">
                <li>
                    <input type="search" ng-model="isbn" name="isbn" placeholder="ISBN *" size="20" minlength="13" maxlength="13" autofocus required>
                    <input type="submit" name="isbnSearch" value="Search">
                </li>
                <a href="index.php">Home</a>
            </ul>
        </form>
        <form method="post" action="isbnSearch.php" autocomplete="off" ng-if="hasSearchResult">
            <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
            <div class="formList">
                <div>
                    <label for="title">Title</label>
                    <input type="text" ng-value="title"  name="title" size="20" autofocus required>
                </div>
                <div>
                    <label for="series">Series</label>
                    <input type="text" ng-value="series" name="series" size="20">
                </div>
                <div>
                    <label for="seriesNumber">No.</label>
                    <input type="number" ng-value="seriesNumber" name="seriesNumber" size="2">
                </div>
                <div>
                    <label for="pageCount">Pages</label>
                    <input type="text" ng-value="pageCount" name="pageCount" size="3">
                </div>
                <div>
                    <label for="authors">Authors</label>
                    <input type="text" ng-value="authors" name="authors" size="20" required>
                </div>
                <div>
                    <label for="year">Year</label>
                    <input type="text" ng-value="publishDate" name="year" size="4" required>
                </div>
                <div>
                    <label for="isbn">ISBN</label>
                    <input type="text" ng-value="isbn" name="isbn" size="13" required>
                </div>
                <div>
                    <label for="genre">Genre</label>
                    <select name="genre" required>
                        <option value="" disabled selected hidden></option>
                        <option value="Art">Art</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Horror">Horror</option>
                        <option value="Nonfiction">Nonfiction</option>
                        <option value="Philosophy">Philosophy</option>
                        <option value="Reference">Reference</option>
                        <option value="Sci-fi">Sci-fi</option>
                        <option value="Young Adult">Young Adult</option>
                    </select>
                </div>
                <div style="display:block;">
                    <label for="description">Description</label>
                    <textarea ng-value="description" rows="6" style="width:100%" name="description" placeholder="Description"></textarea>
                </div>
                <div>
                    <input type="submit" name="addBook" value="Add Book">
                </div>
                <div style="display:block;text-align:center;">
                    <a href="index.php">Home</a>
                </div>
            </div>
        </form>
    </body>
</html>

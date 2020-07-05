<?php
    session_start();
    require_once __DIR__ . "/Objects/Book.php";

    if (!$_SESSION['admin'] || !$_SESSION['loggedIn']) {
        header("Location:login.php");
    }

    if (isset($_POST['addBook'])) {
        $book = new Book();
        $book->createNewBook();
    }

?>
<html ng-app="ISBNSearch">
    <head>
        <title>Add Book</title>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script>
        <script src="angularJS/isbnSearchController.js"></script>
        <link rel="stylesheet" href="CSS/formStyle.css">
        <link rel="stylesheet" href="CSS/sharedStyles.css">
    </head>
    <body ng-controller="MainController">
        <form autocomplete="off" ng-submit="search(isbn)" ng-if="!hasSearchResult">
            <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
            <ul class="formList">
                <li>
                    <input type="search" ng-model="isbn" name="isbn" placeholder="ISBN *" size="20" minlength="10" maxlength="13"autofocus required>
                    <input type="submit" name="isbnSearch" value="Search">
                </li>
                <a href="index.php">Home</a>
            </ul>
        </form>
        <form method="post" action="isbnSearch.php" autocomplete="off" ng-if="hasSearchResult">
            <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
            <div class="formList">
                <div style="width:45%;">
                    <label for="title">Title</label>
                    <input type="text" ng-value="title"  name="title" style="width:100%;" autofocus required>
                </div>
                <div style="width:45%;">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" ng-value="subtitle"  name="subtitle" style="width:100%;">
                </div>
                <div>
                    <label for="series">Series</label>
                    <input type="text" ng-value="series" name="series" size="20">
                </div>
                <div>
                    <label for="seriesNumber">No.</label>
                    <input type="number" ng-value="seriesNumber" name="seriesNumber" size="2">
                </div>
                <div style="width:45%">
                    <label for="authors">Authors</label>
                    <input type="text" ng-value="authors" name="authors" style="width:100%" required>
                </div>
                <div style="width:45%">
                    <label for="publisher">Publisher</label>
                    <input type="text" ng-value="publisher" name="publisher" style="width:100%" required>
                </div>
                <div>
                    <label for="year">Year</label>
                    <input type="text" ng-value="publishDate" name="year" maxlength="4" size="3" required>
                </div>
                <div>
                    <label for="pageCount">Pages</label>
                    <input type="text" ng-value="pageCount" name="pageCount" size="2">
                </div>
                <div style="display:none">
                    <input type="hidden" ng-value="isbn" name="isbn">
                </div>
                <div style="display:none">
                    <input type="hidden" ng-value="imageURL" name="imageURL">
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

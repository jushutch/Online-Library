<?php
    session_start();
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        $userId = $_SESSION['userId'];
        $navigationLinks = "<a href='logout.php'>Logout</a> | 
                                <a href='index.php'>Home</a>";
    }
    else {
        $navigationLinks = "<a href='login.php'>Login</a> | 
                                <a href='signup.php'>Sign up</a>";
    }
?>
<html ng-app="accountModule" lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-route.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.7/angular-resource.min.js"></script>
    <link rel="stylesheet" href="CSS/sharedStyles.css">
    <link rel="stylesheet" href="CSS/indexStyle.css">
    <link rel="stylesheet" href="CSS/formStyle.css">
    <link rel="stylesheet" href="CSS/searchResultStyle.css">
    <link rel="stylesheet" href="CSS/accountStyle.css">
    <script>var userId = <?= $userId ?>;
        var app = angular.module("accountModule", []);</script>
    <script src="angularJS/accountController.js"></script>
    <script src="angularJS/adminController.js"></script>
    <title>Library of Time</title>
</head>
<body  ng-controller="AccountController">
    <div class="topMenu">
        <?= $navigationLinks?>
    </div>

    <div style="width:fit-content; margin: auto;">
        <button class="accountTab" ng-click="setActive('checkedOutBooks')">Checked Out</button>
        <button class="accountTab" ng-click="setActive('onHoldBooks')">On Hold</button>
        <button class="accountTab" ng-click="setActive('accountInfo')">Account Info</button>
        <? if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            echo "<button class=\"accountTab\" ng-click=\"setActive('admin')\">Admin</button>";
        } ?>
        <div class="border" style="width:600px;height:400px;max-width:none;border-radius:0 10px 10px 10px;top:inherit;transform: none;">
            <account-details account-details="accountDetails" ng-if="isActive('accountInfo')"></account-details>
            <table ng-if="isActive('checkedOutBooks')" style="margin:auto;width:80%;">
                <tr style="text-align:left;">
                    <th>Title</th>
                    <th>ISBN</th>
                </tr>
                <tr ng-repeat="book in checkedOut">
                    <td>{{book.title}}</td>
                    <td>{{book.isbn}}</td>
                </tr>
            </table>
            <admin ng-if="isActive('admin')"></admin>
        </div>
    </div>

</body>
</html>
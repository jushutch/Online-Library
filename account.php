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
        <button class="accountTab"
                ng-click="setActive('checkedOutBooks')"
                ng-style="(isActive('checkedOutBooks') && {'background-color':'#305A72'})">Checked Out
        </button>
        <button class="accountTab"
                ng-click="setActive('onHoldBooks')"
                ng-style="(isActive('onHoldBooks') && {'background-color':'#305A72'})">On Hold
        </button>
        <button class="accountTab"
                ng-click="setActive('accountInfo')"
                ng-style="(isActive('accountInfo') && {'background-color':'#305A72'})">Account Info
        </button>
        <? if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            echo "<button class=\"accountTab\" 
                          ng-click=\"setActive('admin')\"
                          ng-style=\"(isActive('admin') && {'background-color':'#305A72'})\">Admin
                 </button>";
        } ?>
        <div class="border" style="width:600px;height:400px;max-width:none;border-radius:0 10px 10px 10px;top:inherit;transform: none;">
            <account-details account-details="accountDetails" ng-if="isActive('accountInfo')"></account-details>
            <div ng-if="isActive('checkedOutBooks')" style="height:100%">
                <div class="book_list">
                    <table  style="margin:auto;width:100%;border-collapse: collapse;">
                        <tr>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Due Date</th>
                        </tr>
                        <tr ng-repeat="book in checkedOut">
                            <td>{{book.title}}</td>
                            <td>{{book.isbn}}</td>
                            <td>{{book.dueDate.substr(0, 10)}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div ng-if="isActive('onHoldBooks')" style="height:100%">
                <div class="book_list">
                    <table  style="margin:auto;width:100%;border-collapse: collapse;">
                        <tr>
                            <th>Title</th>
                            <th>ISBN</th>
                        </tr>
                        <tr ng-repeat="book in onHold">
                            <td>{{book.title}}</td>
                            <td>{{book.isbn}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <admin ng-if="isActive('admin')"></admin>
        </div>
    </div>

</body>
</html>
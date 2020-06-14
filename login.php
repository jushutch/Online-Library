<?php
    session_start();
    include_once "User.php";
    $errorMessage = "";

    if(isset($_POST['login'])) {
        $user = new User();
        if ($user->isValidLogin($_POST['accountNumber'], $_POST['password'])) {
            $_SESSION['loggedIn'] = true;
        }
        else {
            $errorMessage = "Either the account number or password is incorrect";
        };
    }

    if($_SESSION['loggedIn']) {
        header("Location:index.php");
    }

?>
<html>
    <head>
        <link rel="stylesheet" href="sharedStyles.css">
        <link rel="stylesheet" href="formStyle.css">
    </head>
    <body>
        <form method="post" action="login.php" id="createUserForm">
            <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
            <ul class="formList">
                <li>
                    <input type="text" name="accountNumber" placeholder="Account Number *" size="30" autofocus required>
                </li>
                <li>
                    <input type="password" name="password" placeholder="Password *" minlength="6" size="30" required>
                </li>
                <span class="message"> <?= $errorMessage ?> </span>
                <li>
                    <input type="submit" name="login" value="Login">
                </li>
                <a href="index.php">Home</a>
                <br>
                <a href="createAccount.php">Create Account</a>
            </ul>
        </form>
    </body>
</html>

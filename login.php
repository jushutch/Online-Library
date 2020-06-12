<?php
    session_start();
    $errorMessage = "";
    if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
        header("Location:index.php");
    }

    if(isset($_POST['login'])) {
        $errorMessage = validateLogin();
        //setSessionVariables();
    }

    function validateLogin() {
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $accountNumber = $_POST['accountNumber'];
        if (!isValidLoginCredentials($accountNumber, $hashedPassword)) {
            $_SESSION['loggedIn'] = false;
            return "Either your account number or password are incorrect";
        }
        $_SESSION['accountNumber'] = $accountNumber;
        $_SESSION['loggedIn'] = true;
        return "";
    }

    function isValidLoginCredentials($accountNumber, $hashedPassword) {
        return $accountNumber == 1 
            && password_verify("password", $hashedPassword);
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
                <a href="createUser.php">Create Account</a>
            </ul>
        </form>
    </body>
</html>

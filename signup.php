<?php
    session_start();
    require_once "Objects/User.php";
    $newUser = new User();

    if(isset($_POST['createNewUser'])) {
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        $email = strtolower($_POST['email']);
        if ($password !== $passwordConfirm) {
            $passwordMessage = "Passwords do not match, please try again";
        } else if ($newUser->isEmailTaken($email)) {
            $passwordMessage = "Email is already taken, please use another";
        }
        else {
            $newAccountId = $newUser->createUser();
            $passwordMessage = "Your id number is: $newAccountId";
            //header("Location: index.php");
        }
    } else {
        $passwordMessage = "Password must be at least 6 characters";
    }

?>
<html>
    <head>
        <title>Sign Up</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="CSS/sharedStyles.css">
        <link rel="stylesheet" href="CSS/formStyle.css">
    </head>
    <body>
        <form class="border" method="post" action="signup.php" id="createUserForm">
            <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
            <ul class="formList">
                <li>
                    <input type="text" name="firstName" placeholder="First Name *" autofocus required>
                    <input type="text" name="lastName" placeholder="Last Name">
                </li>
                <li>
                    <input type="email" name="email" placeholder="E-Mail *" style="width:100%;" required>
                </li>
                <li>
                    <input type="password" name="password" minlength="6" placeholder="Password *" required>
                    <input type="password" name="passwordConfirm" minlength="6" placeholder="Confirm Password *" required>
                </li>
                <p class="message"><?= $passwordMessage ?></p>
                <li>
                    <input type="submit" name="createNewUser" value="Create Account">
                </li>
                <a href="index.php">Home</a>
                <span style="padding-left:1em"></span>
                <a href="login.php">Login</a>
            </ul>
        </form>
    </body>
</html>
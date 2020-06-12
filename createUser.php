<?php
    session_start();
    $random = rand();
    $_SESSION['random'] = $random;
    if(isset($_POST['createNewUser']) && $_POST['randomCheck']==$_SESSION['random']) {
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        if ($password !== $passwordConfirm) {
            $passwordMessage = "Passwords do not match, please try again";
        }
    } else {
        $passwordMessage = "Password must be at least 6 characters";
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="sharedStyles.css">
        <link rel="stylesheet" href="formStyle.css">
    </head>
    <body>
        <form method="post" action="createUser.php" id="createUserForm">
            <input type="hidden" value="<?php echo $random; ?>" name="randomCheck" />
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
<?php
    if(isset($_POST['createNewUser'])) {
        //echo "<h1>".$_POST['firstName']."</h1>";
        //createNewUser();
    }
?>
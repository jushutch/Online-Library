<?php
    session_start();
    if (isset($_SESSION['loggedIn'])) {
        $navigationLinks = "<a href=\"logout.php\">Logout</a>";
    } else {
        $navigationLinks = "<a href='login.php'>Login</a>
                            <br>
                            <a href='createAccount.php'>Create Account</a>";
    }

?>
<html>
    <head>
        <link rel="stylesheet" href="sharedStyles.css">
        <link rel="stylesheet" href="indexStyle.css">
        <title>Library of Time</title>
    </head>
    <body>
            <div id="searchBarWrapper">
                <div style="text-align:center;">
                    <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
                </div>
                <form action="index.php" method="post" class="search">
                    <input type="text" placeholder="Search Library" name="searchTerms" class="searchTerm" autocomplete="off" autofocus>
                    <input type="submit" value="Search" class="searchButton">
                </form>
                <div style="height:120px;text-align:center">
                    <div style="padding:20px;">
                        <?= $navigationLinks ?>
                    </div>
                </div>
            </div>
    </body>
</html>
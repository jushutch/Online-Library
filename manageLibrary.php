<?php
    session_start();
    require_once "Book.php";

    if (!$_SESSION['admin'] || !$_SESSION['loggedIn']) {
        header("Location:login.php");
    }

    if (isset($_POST['addBook'])) {
        $book = new Book();
        $book->createNewBook();
    }

?>
<html>
    <head>
        <link rel="stylesheet" href="sharedStyles.css">
        <link rel="stylesheet" href="formStyle.css">
    </head>
    <body>
        <form method="post" action="manageLibrary.php" autocomplete="off">
            <a href="index.php"><img class="logo" src="images/logo.png" alt="Library of Time"></a>
            <ul class="formList">
                <li>
                    <input type="text" name="title" placeholder="Title" size="20" autofocus>
                    <input type="text" name="series" placeholder="Series" size="20">
                    <input type="number" name="seriesNumber" placeholder="No.">
                </li>
                <li>
                    <input type="text" name="authors" placeholder="Authors" size="20">
                    <input type="number" name="year" placeholder="Year" size="5">
                    <input type="text" name="isbn" placeholder="ISBN" size="13">
                    <select name="genre" required>
                        <option value="" disabled selected hidden>Genre</option>
                        <option value="Art">Art</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Horror">Horror</option>
                        <option value="Nonfiction">Nonfiction</option>
                        <option value="Philosophy">Philosophy</option>
                        <option value="Reference">Reference</option>
                        <option value="Sci-fi">Sci-fi</option>
                        <option value="Young Adult">Young Adult</option>
                    </select>
                </li>
                <li>
                    <input type="submit" name="addBook" value="Add Book">
                </li>
                <a href="index.php">Home</a>
            </ul>
        </form>
    </body>
</html>
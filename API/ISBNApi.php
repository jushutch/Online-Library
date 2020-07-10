<?php
    require_once __DIR__ . "/ISBNService.php";
    $isbn = $_GET['isbn'];
    $ISBNService = new ISBNService();
    $book = $ISBNService->getBookFromAPIByISBN($isbn);
    echo json_encode($book);
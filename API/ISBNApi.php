<?php
    require_once __DIR__ . "/ISBNService.php";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $isbn = $request['isbn'];
    $ISBNService = new ISBNService();
    $book = $ISBNService->getBookFromAPIByISBN($isbn);
    echo json_encode($book);
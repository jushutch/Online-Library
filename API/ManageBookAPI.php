<?php
    require_once __DIR__ . "/ManageBookService.php";
    require_once __DIR__ . "/../objects/Book.php";
    const ACTION_UPDATE = "update";
    const ACTION_DELETE = "delete";
    const ACTION_CHECK_IN = "check_in";
    const ACTION_ADD_BOOK = "add_book";
    $request = $_GET;
    $action = isset($request['action']) ? $request['action'] : null;
    $book = isset($request['book']) ? json_decode($request['book'], true) : null;
    $manageBookService = new ManageBookService();
    switch($action) {
        case ACTION_UPDATE:
            $manageBookService->updateBook($book);
             break;
        case ACTION_DELETE:
            $manageBookService->deleteBook($book);
            break;
        case ACTION_CHECK_IN:
            $manageBookService->checkInBook($book);
            $manageBookService->updateHolds($book);
            break;
        case ACTION_ADD_BOOK:
            $manageBookService->addBook($book);
            break;
    }
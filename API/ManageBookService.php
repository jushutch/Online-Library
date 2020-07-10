<?php

include_once __DIR__ . " /../database/BookDbGateway.php";

class ManageBookService
{
    private $bookDbGateway;

    public function __construct()
    {
        $this->bookDbGateway = new BookDbGateway();
    }

    public function updateBook($book) {
        if (!$book) {
            return;
        }
        echo "bookDbGateway->update called";
        $this->bookDbGateway->updateBook($book);
    }

    public function deleteBook($book) {
        if (!isset($book['bookId']) || !$book['bookId']) {
            return;
        }
        $this->bookDbGateway->deleteBookByBookId($book['bookId']);
    }

    public function checkInBook($book) {
        if (!isset($book['bookId']) || !$book['bookId']) {
            return;
        }
        $this->bookDbGateway->checkInBook($book['bookId']);
    }

}
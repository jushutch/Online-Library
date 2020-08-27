<?php

include_once __DIR__ . " /../database/BookDbGateway.php";
include_once __DIR__ . "/../objects/Book.php";

class ManageBookService
{
    private $bookDbGateway;

    public function __construct()
    {
        $this->bookDbGateway = new BookDbGateway();
    }

    public function addBook($book) {
        if (!$book) {
            return;
        }
        $book = Book::fromArray($book);
        $this->bookDbGateway->insertBook($book);
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

    public function updateHolds($book) {
        if (!isset($book['bookId']) || !$book['bookId']) {
            return;
        }
        $firstOnHoldAccountId = $this->bookDbGateway->getFirstOnHoldAccountId($book['bookId']);
        if ($firstOnHoldAccountId) {
            $this->bookDbGateway->fulfillHold($book['bookId'], $firstOnHoldAccountId);
            $this->bookDbGateway->checkoutBook($book['bookId'], $firstOnHoldAccountId);
        }
    }

}
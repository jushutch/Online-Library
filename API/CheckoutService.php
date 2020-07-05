<?php

include_once __DIR__ . "/../database/BookDbGateway.php";

class CheckoutService
{
    private $bookDbGateway;

    public function __construct()
    {
        $this->bookDbGateway = new BookDbGateway();
    }

    public function checkoutBook($isbn, $userId) {
        $bookId = $this->bookDbGateway->getBookIdByISBN($isbn);
        if ($this->bookDbGateway->isBookIdCheckedOut($bookId)) {
            return "Unavailable";
        }
        return $this->bookDbGateway->checkoutBook($isbn, $userId) ? "Available" : "Error";
    }
}
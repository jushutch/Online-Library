<?php

include_once __DIR__ . "/../database/BookDbGateway.php";

class CheckoutService
{
    private $bookDbGateway;

    public function __construct()
    {
        $this->bookDbGateway = new BookDbGateway();
    }

    public function checkoutBook(int $isbn, int $userId) {
        $bookId = $this->bookDbGateway->getBookIdByISBN($isbn);
        if ($this->bookDbGateway->isBookIdCheckedOut($bookId)) {
            return "Unavailable";
        }
        $this->bookDbGateway->checkoutBook($bookId, $userId);
        return "Successfully checked out";
    }

    public function putBookOnHold(int $isbn, int $userId) {
        $bookId = $this->bookDbGateway->getBookIdByISBN($isbn);
        if (!$this->bookDbGateway->isBookOnHoldByAccountNumber($bookId, $userId)) {
            $this->bookDbGateway->putBookOnHold($bookId, $userId);
            return "Successfully put on hold";
        }
        return "Already on hold";
    }
}
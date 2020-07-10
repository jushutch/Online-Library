<?php

include_once __DIR__ . "/../database/UserDbGateway.php";
include_once __DIR__ . "/../database/BookDbGateway.php";
include_once __DIR__ . "/../Objects/Book.php";

class AccountService
{
    private $userDbGateway;
    private $bookDbGateway;
    public function __construct()
    {
        $this->userDbGateway = new UserDbGateway();
        $this->bookDbGateway = new BookDbGateway();
    }

    public function getAccountInfo($accountNumber) {
        $accountInfo = [];
        $accountInfo["checkedOut"] = $this->getCheckedOutBooks($accountNumber);
        $accountInfo["onHold"] = $this->getBooksOnHold($accountNumber);
        $accountInfo["accountDetails"] = $this->getUserDetails($accountNumber);
        return $accountInfo;
    }

    private function getCheckedOutBooks($accountNumber) {
        $books = $this->bookDbGateway->getCheckedOutBooksForAccount($accountNumber);
        $checkedoutBooks = [];
        foreach($books as $book) {
            $checkedoutBooks[] = Book::fromArray($book);
        }
        return $checkedoutBooks;
    }

    private function getBooksOnHold($accountNumber) {
        return null;
    }

    private function getUserDetails($accountNumber) {
        return $this->userDbGateway->getAccountInfo($accountNumber);
    }

}
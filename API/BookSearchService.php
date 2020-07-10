<?php

include_once __DIR__ . "/../database/BookSearchDbGateway.php";
include_once __DIR__ . "/../Objects/Book.php";

class BookSearchService
{
    private $bookSearchDbGateway;

    public function __construct()
    {
        $this->bookSearchDbGateway = new BookSearchDbGateway();
    }

    public function searchForBook($searchText) {
        $searchResults = $this->bookSearchDbGateway->selectBooksLikeSearchText($searchText);
        return $this->searchResultsToBooks($searchResults);
    }

    private function searchResultsToBooks($searchResults) {
        $bookList = [];
        foreach($searchResults as $result) {
            $bookList[] = Book::fromArray($result);
        }
        return $bookList;
    }

}
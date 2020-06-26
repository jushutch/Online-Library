<?php

require_once "database/BookDbGateway.php";

class Book {
    public $title;
    public $authors;
    public $year;
    public $genre;
    public $isbn;
    public $series;
    public $seriesNumber;

    private $bookDbGateway;

    public function __construct() {
        $this->bookDbGateway = new BookDbGateway();
    }

    public function createNewBook() {
        $this->title = $_POST['title'];
        $this->authors = explode(",", $_POST['authors']);
        $this->year = (int)$_POST['year'];
        $this->genre = $_POST['genre'];
        $this->isbn = $_POST['isbn'];
        $this->series = $_POST['series'] ? $_POST['series'] : null;
        $this->seriesNumber = $_POST['seriesNumber'] ? $_POST['seriesNumber'] : null;
        $_POST = array();
        return $this->bookDbGateway->insertBook($this);
    }

}
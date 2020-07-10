<?php

require_once __DIR__ . "/../database/BookDbGateway.php";

class Book {
    public $bookId;
    public $title;
    public $subtitle;
    public $authors;
    public $publisher;
    public $year;
    public $genre;
    public $pageCount;
    public $isbn;
    public $series;
    public $seriesNumber;
    public $description;
    public $imageURL;
    public $isAvailable;

    public function __construct($title,
                                $authors,
                                $publisher,
                                $year,
                                $genre,
                                $pageCount,
                                $isbn,
                                $description,
                                $isAvailable,
                                $imageURL = null,
                                $series = null,
                                $seriesNumber = null,
                                $subtitle = null,
                                $bookId = null) {
        $this->title = $title;
        $this->authors = explode(",", $authors);
        $this->publisher = $publisher;
        $this->year = $year;
        $this->genre = $genre;
        $this->pageCount = $pageCount;
        $this->isbn = $isbn;
        $this->description = $description;
        $this->isAvailable = $isAvailable;
        $this->imageURL = $imageURL ?? "images/logo.png";
        $this->series = $series;
        $this->seriesNumber = $seriesNumber;
        $this->subtitle = $subtitle;
        $this->bookId = $bookId;
    }

    static public function fromArray($book) {
        return new self(
            $book['title'],
            $book['authors'] ?? $book['author_list'],
            $book['publisher'],
            $book['year'],
            $book['genre'],
            $book['pageCount'] ?? $book['page_count'],
            $book['isbn'],
            $book['description'],
            $book['isAvailable'] ?? $book['is_available'],
            isset($book['imageURL']) ? $book['imageURL'] :
                isset($book['image_url']) ? $book['image_url'] : null,
            isset($book['series']) && $book['series'] ? $book['series'] : null,
            isset($book['seriesNumber']) ? $book['seriesNumber'] :
                isset($book['series_number']) ? $book['series_number'] : null,
            isset($book['subtitle']) && $book['subtitle'] ? $book['subtitle'] : null,
            isset($book['bookId']) ? $book['bookId'] :
                isset($book['book_id']) ? $book['book_id'] : null
        );
    }

    public function jsonSerialize() {
        return [
            'bookId' => $this->bookId,
            'title' => $this->title,
            'authors' => $this->authors,
            'publisher' => $this->publisher,
            'year' => $this->year,
            'genre' => $this->genre,
            'pageCount' => $this->pageCount,
            'isbn' => $this->isbn,
            'description' => $this->description,
            'isAvailable' => $this->isAvailable,
            'imageURL' => $this->imageURL,
            'series' => $this->series,
            'seriesNumber' => $this->seriesNumber,
            'subtitle' => $this->subtitle
        ];
    }
}
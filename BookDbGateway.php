<?php

require_once "Gateway.php";

class BookDbGateway extends Gateway {

    public function insertBook($book) {
        $genreId = $this->getGenreId($book->genre);
        $sql = "INSERT INTO book(title, series, series_number, isbn, year, genre_id)
                VALUES ( ? , ? , ? , ? , ? , ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisii",
                            $book->title,
                            $book->series,
                            $book->seriesNumber,
                            $book->isbn,
                            $book->year,
                            $genreId);
        $stmt->execute();
        $bookId = $stmt->insert_id;
        $stmt->close();
        var_dump($book->authors);
        $this->insertAuthors($book->authors, $bookId);
    }

    public function insertAuthors($authors, $bookId) {
        $sql = "INSERT INTO author(book_id, author_name) 
                    VALUES ( ? , ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $bookId, $author);
        foreach ($authors as $author) {
            $stmt->execute();
        }
        $stmt->close();
    }

    private function getGenreId($genre) {
        $sql = "SELECT genre_id FROM genre WHERE genre = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $genre);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result['genre_id'];
    }
}
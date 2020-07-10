<?php

require_once __DIR__ . "/../database/Gateway.php";

class BookDbGateway extends Gateway {

    public function insertBook($book) {
        $genreId = $this->getGenreId($book->genre);
        $sql = "INSERT INTO book(title, subtitle, publisher, series, series_number, page_count, isbn, year, genre_id)
                VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssiisii",
                            $book->title,
                            $book->subtitle,
                            $book->publisher,
                            $book->series,
                            $book->seriesNumber,
                            $book->pageCount,
                            $book->isbn,
                            $book->year,
                            $genreId);
        $stmt->execute();
        $bookId = $stmt->insert_id;
        $stmt->close();
        $this->insertAuthors($book->authors, $bookId);
        if ($book->imageURL) $this->insertImageURL($book->imageURL, $bookId);
        if ($book->description) $this->insertDescription($book->description, $bookId);
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

    public function deleteAuthors($bookId) {
        $sql = "DELETE FROM author
                WHERE author.book_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $stmt->close();
    }

    public function insertDescription($description, $bookId) {
        $sql = "INSERT INTO book_description(book_id, description) 
                    VALUES ( ? , ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $bookId, $description);
        $stmt->execute();
        $stmt->close();
    }

    public function insertImageURL($imageURL, $bookId) {
        $sql = "INSERT INTO book_image(book_id, image_url) 
                    VALUES ( ? , ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $bookId, $imageURL);
        $stmt->execute();
        $stmt->close();
    }

    public function checkoutBook($isbn, $userId) {
        $sql = "INSERT INTO checkout(book_id, account_number, due_date) 
                VALUES ( ? , ? , DATE_ADD(CURRENT_TIMESTAMP(), INTERVAL 1 MONTH))";
        $bookId = (int) $this->getBookIdByISBN($isbn);
        if (!$bookId) {
            return;
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $bookId, $userId);
        $stmt->execute();
        $stmt->close();
    }

    public function checkInBook($bookId) {
        $sql = "UPDATE checkout SET return_date = CURRENT_TIMESTAMP() WHERE checkout.book_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $stmt->close();
        echo "end of checkInBook reached";
    }

    public function isBookIdCheckedOut($bookId) {
        $sql = "SELECT checkout_id FROM checkout WHERE book_id = ? AND return_date IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $stmt->store_result();
        $rowCount = $stmt->num_rows;
        $stmt->close();
        return $rowCount > 0;
    }

    public function getCheckedOutBooksForAccount($accountNumber) {
        $selectAuthors = "(SELECT GROUP_CONCAT(author_name) as author_list, book_id 
                            FROM author
                            GROUP BY book_id) as authors";
        $sql = "SELECT DISTINCT checkout.due_date, author_list, book.book_id, title, subtitle, publisher, year, page_count, isbn, series, series_number, description, image_url, genre
                FROM $selectAuthors
                LEFT JOIN book on book.book_id = authors.book_id
                left JOIN book_description on book_description.book_id = book.book_id
                left JOIN book_image on book_image.book_id = book.book_id
                left join author on author.book_id = book.book_id
                INNER JOIN genre on genre.genre_id = book.genre_id
                left join checkout on checkout.book_id = book.book_id
                WHERE checkout.account_number = ? AND checkout.return_date IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $accountNumber);
        $stmt->execute();
        $result = $stmt->get_result();
        $bookData = [];
        while($book = $result->fetch_assoc()) {
            $bookData[] = $book;
        }
        $stmt->close();
        return $bookData;
    }

    public function getBookIdByISBN($isbn) {
        $sql = "SELECT book_id
                FROM book
                WHERE isbn = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row['book_id'] ?? null;
    }

    public function getBookByBookId($bookId) {
        $selectAuthors = "(SELECT GROUP_CONCAT(author_name) as author_list, book_id 
                            FROM author
                            GROUP BY book_id) as authors";
        $sql = "SELECT DISTINCT author_list, book.book_id, title, subtitle, publisher, year, page_count, isbn, series, series_number, description, image_url, genre
                FROM $selectAuthors
                LEFT JOIN book on book.book_id = authors.book_id
                left JOIN book_description on book_description.book_id = book.book_id
                left JOIN book_image on book_image.book_id = book.book_id
                left join author on author.book_id = book.book_id
                INNER JOIN genre on genre.genre_id = book.genre_id
                WHERE book.book_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $bookId);
        $stmt->execute();
        $book = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $book;
    }

    public function updateBook(array $book) {
        $sql = "UPDATE book, book_description, book_image, genre
                SET title = ?, subtitle = ?, publisher = ?, year = ?, page_count = ?, isbn = ?, series = ?, series_number = ?, description = ?, image_url = ?, genre = ?
                WHERE book.book_id = book_description.book_id
                AND book.book_id = book_image.book_id
                AND book.genre_id = genre.genre_id
                AND book.book_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssiississsi",
            $book['title'],
            $book['subtitle'],
            $book['publisher'],
            $book['year'],
            $book['pageCount'],
            $book['isbn'],
            $book['series'],
            $book['seriesNumber'],
            $book['description'],
            $book['imageURL'],
            $book['genre'],
            $book['bookId']
        );
        $stmt->execute();
        var_dump($book);
        $stmt->close();
        $this->deleteAuthors($book['bookId']);
        $this->insertAuthors($book['authors'], $book['bookId']);
    }

    public function deleteBookByISBN($isbn) {
        $sql = "DELETE FROM book
                WHERE isbn = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteBookByBookId($bookId) {
        $sql = "DELETE FROM book
                WHERE book_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $bookId);
        $stmt->execute();
        $stmt->close();
    }

    private function getGenreId($genre) {
        $sql = "SELECT genre_id FROM genre WHERE genre = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $genre);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result['genre_id'] ?? null;
    }
}
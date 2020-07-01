<?php

include_once __DIR__ . "/Gateway.php";

class BookSearchDbGateway extends Gateway
{

    public function selectBooksLikeSearchText($searchText) {
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
                WHERE (title LIKE ?)
                OR (description LIKE ?)
                OR (author_list LIKE ?)
                OR (series LIKE ?)
                OR (subtitle LIKE ?)
                OR (publisher LIKE ?)
                OR (genre LIKE ?)";
        $query = "%".$searchText."%";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss", $query, $query, $query, $query, $query, $query, $query);
        $stmt->execute();
        $searchResults = [];
        $result = $stmt->get_result();
        $stmt->close();
        while ($row = $result->fetch_assoc()) {
            $row["authors"] = explode(",", $row["author_list"]);
            $searchResults[] = $row;
        }
        return $searchResults;
    }
}
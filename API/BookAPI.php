<?php
    require_once __DIR__ . "/BookSearchService.php";
    $searchString = $_GET['searchText'];
    $bookSearchService = new BookSearchService();
    $searchResults = $bookSearchService->searchForBook($searchString);
    echo json_encode($searchResults);
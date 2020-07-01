<?php
    require_once "..\API\BookSearchService.php";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $searchString = $request['searchText'];
    $bookSearchService = new BookSearchService();
    $searchResults = $bookSearchService->searchForBook($searchString);
    echo json_encode($searchResults);
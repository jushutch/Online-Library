<?php
    require_once __DIR__ . "/AccountService.php";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    if (isset($request['userId'])) {
        $accountService = new AccountService();
        $accountInfo = $accountService->getAccountInfo($request['userId']);
        echo json_encode($accountInfo);
    } else {
        echo "Error";
    }
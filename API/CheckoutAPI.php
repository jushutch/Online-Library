<?php
    require_once __DIR__ . "/CheckoutService.php";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    if (isset($request['isbn']) && isset($request['userId'])) {
        $checkoutService = new CheckoutService();
        echo $checkoutService->checkoutBook($request['isbn'], $request['userId']);
    } else {
        echo "Error";
    }
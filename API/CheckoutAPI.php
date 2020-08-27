<?php
    require_once __DIR__ . "/CheckoutService.php";
    const ACTION_CHECKOUT = "checkout";
    const ACTION_PUT_ON_HOLD = "put_on_hold";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata, true);
    $action = isset($request['action']) ? $request['action'] : null;
    if (isset($request['isbn']) && isset($request['userId'])) {
        $checkoutService = new CheckoutService();
        switch($action) {
            case ACTION_CHECKOUT:
                echo $checkoutService->checkoutBook($request['isbn'], $request['userId']);
                break;
            case ACTION_PUT_ON_HOLD:
                echo $checkoutService->putBookOnHold($request['isbn'], $request['userId']);
                break;
            default:
                echo "Error: invalid action parameter";
                break;
        }
    } else {
        echo "Error: invalid parameters (isbn and userId)";
    }
<?php

// http://localhost/finalWeb/backend/rest/connection-check
Flight::route('GET /connection-check', function () {
    Flight::json(Flight::examService()->connection_check());
});

Flight::route('GET /employees/performance', function () {
    Flight::json(Flight::examService()->employees_performance_report());
});

// returns json {message: "xy"}
Flight::route('DELETE /employee/delete/@employee_id', function ($employee_id) {
    $message = Flight::examService()->delete_employee($employee_id);
    Flight::json(['message' => $message]);
});

Flight::route('PUT /employee/edit/@employee_id', function ($employee_id) {
    $raw_body = Flight::request()->getBody();

    // because of Undefined array key error
    $data = json_decode($raw_body, true);

    if (isset($data['first_name']) && isset($data['last_name']) && isset($data['email'])) {
        $response = Flight::examService()->edit_employee($employee_id, $data);
        Flight::json($response);
    } else {
        $error = ["message" => "Missing required fields", "status" => "Failed"];
        Flight::json($error, 400); // 400 - bad request
    }
});


Flight::route('GET /orders/report', function () {
    /** TODO
     * This endpoint should return the report for every order in the database.
     * For every order we need the amount of money spent for the order. In order
     * to get total money for every order quantityOrdered should be multiplied 
     * with priceEach from the orderdetails table. The data should be summarized
     * in order to get accurate report. Every item returned should 
     * have following properties:
     *   `details` -> the html code needed on the frontend. Refer to `orders.html` page
     *   `order_number` -> orderNumber of the order
     *   `total_amount` -> aggregated amount of money spent per order
     * This endpoint should return output in JSON format
     * 10 points
     */

    Flight::json(Flight::examService()->get_orders_report());
});

Flight::route('GET /order/details/@order_id', function ($order_id) {
    /** TODO
     * This endpoint should return the array of all products in a single 
     * order with the provided id. Every food returned should have 
     * following properties:
     *   `product_name` -> productName from the database
     *   `quantity` -> quantity from the orderdetails table
     *   `price_each` -> priceEach from the orderdetails table
     * This endpoint should return output in JSON format
     * 10 points
     */
    
    Flight::json(Flight::examService()->get_order_details($order_id));
});

<?php
header('Content-Type: application/json; charset=utf-8');
require("../snippets/base.php");

// Validate and sanitize user inputs
$requiredFields = ["car_plate"];
$data = checkAndCleanGETInputs($requiredFields);
if (isset($data["errors"])) {
    // 400 means bad request (wrong inputs)
    http_response_code(400);
    echo json_encode(["errors" => $data["errors"]]);
    exit();
}

// Check if the car_plate is already in use
echo json_encode(isCarPlateAlreadyUsed($connection, $data["car_plate"]));


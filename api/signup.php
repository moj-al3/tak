<?php
require("../utils/database_connection.php");
require("../utils/validators.php");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 405 means we are using the wrong method
    http_response_code(405);
    exit();
}


// Validate and sanitize user inputs
$requiredFields = ["user_id", "first_name", "last_name", "email", "password", "user_type_id", "car_type", "car_plate"];
$data = checkAndCleanPostInputs($requiredFields);

if (isset($data["errors"])) {
    // 400 means bad request (wrong inputs)
    http_response_code(400);
    echo json_encode(["errors" => $data["errors"]]);
    exit();
}

// Check if the email is already in use
if (isEmailAlreadyUsed($connection, $data["email"])) {
    http_response_code(400);
    echo json_encode(["errors" => ["email" => "Email Already In Use"]]);
    exit();
}

// Hash the password before storing it
$hashedPassword = password_hash($data["password"], PASSWORD_DEFAULT);

// Store user information in the database using prepared statements
$insertUserQuery = $connection->prepare("INSERT INTO users (user_id, first_name, last_name, password, email, user_type_id) VALUES (?, ?, ?, ?, ?, ?)");

$insertUserQuery->bind_param("issssi", $data["user_id"], $data["first_name"], $data["last_name"], $hashedPassword, $data["email"], $data["user_type_id"]);

if (!$insertUserQuery->execute()) {
    // 500 means Internal error (something went wrong)
    http_response_code(500);
    echo json_encode(["message" => "User creation failed"]);
    exit();
}

// Store user car information in the database using prepared statements
$insertCarQuery = $connection->prepare("INSERT INTO cars(owner_id, car_type, car_plate) VALUES (?, ?, ?)");
$insertCarQuery->bind_param("iss", $data["user_id"], $data["car_type"], $data["car_plate"]);

if (!$insertCarQuery->execute()) {
    // 500 means Internal error (something went wrong)
    http_response_code(500);
    echo json_encode(["message" => "Car creation failed"]);
    exit();
}

echo json_encode(["message" => "Account Created Successfully"]);

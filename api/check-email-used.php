<?php
require("../snippets/database_connection.php");
require("../snippets/validators.php");
header('Content-Type: application/json; charset=utf-8');


// Validate and sanitize user inputs
$requiredFields = ["email"];
$data = checkAndCleanGETInputs($requiredFields);
if (isset($data["errors"])) {
    // 400 means bad request (wrong inputs)
    http_response_code(400);
    echo json_encode(["errors" => $data["errors"]]);
    exit();
}

// Check if the email is already in use
echo json_encode(isEmailAlreadyUsed($connection, $data["email"]));


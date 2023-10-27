<?php
require("../snippets/database_connection.php");
require("../snippets/validators.php");
header('Content-Type: application/json; charset=utf-8');


// Validate and sanitize user inputs
$requiredFields = ["user_id"];
$data = checkAndCleanGETInputs($requiredFields);
if (isset($data["errors"])) {
    // 400 means bad request (wrong inputs)
    http_response_code(400);
    echo json_encode(["errors" => $data["errors"]]);
    exit();
}

// Check if the user_id is already in use
echo json_encode(isUserIDAlreadyUsed($connection, $data["user_id"]));


<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}
?>
<?php
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isEmailAlreadyUsed($connection, $email)
{
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT COUNT(*) as count FROM users WHERE email = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Database error: " . $connection->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("s", $email);
    $stmt->execute();

    // Check for errors in the query execution
    if ($stmt->error) {
        die("Query error: " . $stmt->error);
    }

    // Get the result
    $stmt->bind_result($count);
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // If count is greater than 0, the email exists in the database
    return $count > 0;
}


function isUserIDAlreadyUsed($connection, $id)
{
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT COUNT(*) as count FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Database error: " . $connection->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("s", $id);
    $stmt->execute();

    // Check for errors in the query execution
    if ($stmt->error) {
        die("Query error: " . $stmt->error);
    }

    // Get the result
    $stmt->bind_result($count);
    $stmt->fetch();

    // Close the statement
    $stmt->close();

    // If count is greater than 0, the user ID exists in the database
    return $count > 0;
}


function checkAndCleanPostInputs($requiredInputs)
{

    // Check if all of the required inputs are present in the POST request.
    $errors = [];
    foreach ($requiredInputs as $input) {
        if (!isset($_POST[$input])) {
            $errors[$input] = 'this field is required';
        }
    }

    // If there are any errors, return the dictionary of errors.
    if (!empty($errors)) {
        return ['errors' => $errors];
    }

    // Clean the POST inputs.
    $cleanedInputs = [];
    foreach ($requiredInputs as $input) {
        $cleanedInputs[$input] = filter_var($_POST[$input], FILTER_SANITIZE_STRING);
    }


    // return the cleaned inputs.
    return $cleanedInputs;
}

function checkAndCleanGETInputs($requiredInputs)
{

    // Check if all of the required inputs are present in the GET request.
    $errors = [];
    foreach ($requiredInputs as $input) {
        if (!isset($_GET[$input])) {
            $errors[$input] = 'this field is required';
        }
    }

    // If there are any errors, return the dictionary of errors.
    if (!empty($errors)) {
        return ['errors' => $errors];
    }

    // Clean the GET inputs.
    $cleanedInputs = [];
    foreach ($requiredInputs as $input) {
        $cleanedInputs[$input] = filter_var($_GET[$input], FILTER_SANITIZE_STRING);
    }


    // return the cleaned inputs.
    return $cleanedInputs;
}
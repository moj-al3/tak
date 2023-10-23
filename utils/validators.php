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
    // Query to check for the email
    $sql = "SELECT COUNT(*) FROM users WHERE email = '{$email}'";
    $result = $connection->query($sql);

    if ($result === false) {
        die("Database error: " . mysqli_error($connection));
    }

    // If num_rows is greater than 0, the email exists in the database
    return $result->fetch_assoc()["COUNT(*)"] > 0;

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

    // Clean the POST inputs.
    $cleanedInputs = [];
    foreach ($requiredInputs as $input) {
        if (!isset($errors[$input])) {
            $cleanedInputs[$input] = filter_var($_POST[$input], FILTER_SANITIZE_STRING);
        }
    }

    // If there are any errors, return the dictionary of errors.
    if (!empty($errors)) {
        return ['errors' => $errors];
    }

    // Otherwise, return the cleaned inputs.
    return $cleanedInputs;
}

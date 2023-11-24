<?php

// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}


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
    $sql = "SELECT COUNT(*) as count FROM Users WHERE email = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Database error: " . $connection->error);
    }


    // Bind the parameter and execute the query
    $stmt->bind_param("s", $email);
    if ($stmt->execute() == false) {
        die("Query error: " . $stmt->error);
    }
    // Get the result
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();


    // If count is greater than 0, the email exists in the database
    return $count > 0;


}


function isUserIDAlreadyUsed($connection, $id)
{
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT COUNT(*) as count FROM Users WHERE user_id = ?";
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

function isCarPlateAlreadyUsed($connection, $carPlate)
{
    // Convert car plate to uppercase
    $carPlate = strtoupper($carPlate);
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT COUNT(*) as count FROM Cars WHERE car_plate = ? and deleted=FALSE";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        die("Database error: " . $connection->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("s", $carPlate);
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

    // If count is greater than 0, the car plate is already in use in the database
    return $count > 0;
}


function checkAndCleanPostInputs($requiredInputs)
{

    // Check if all of the required inputs are present in the POST request.
    $errors = [];
    foreach ($requiredInputs as $input) {
        if (!isset($_POST[$input]) || empty($_POST[$input])) {
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
        if (!isset($_GET[$input]) || empty($_GET[$input])) {
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


function saveProfile($connection, $user)
{

    $data = checkAndCleanPostInputs(["first_name", "last_name", "email"]);

    // Check for errors in input
    if (isset($data["errors"])) {
        $_SESSION['messages'] = [["text" => "All Fields are required", "type" => "error"]];
        return;
    }
    $user_id = $user["user_id"];

    // Extract sanitized inputs
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $email = $data['email'];

    // Check if the new email is already in use by other users
    $emailInUseQuery = "SELECT user_id FROM Users WHERE email = ? AND user_id != ?";
    $emailInUseStatement = $connection->prepare($emailInUseQuery);
    $emailInUseStatement->bind_param("si", $email, $user_id);
    $emailInUseStatement->execute();
    $emailInUseResult = $emailInUseStatement->get_result();

    if ($emailInUseResult->num_rows > 0) {
        $_SESSION['messages'] = [["text" => "Email is already in use by another user.", "type" => "error"]];
        return;
    }
    // Update user information in the database
    $updateUserQuery = "UPDATE Users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?";
    $updateStatement = $connection->prepare($updateUserQuery);
    $updateStatement->bind_param("sssi", $first_name, $last_name, $email, $user_id);
    $updateStatement->execute();
    if ($updateStatement == false) {
//        echo "Error: No rows were updated. " . $connection->error;
        $_SESSION['messages'] = [["text" => "Something went wrong, please try again later.", "type" => "error"]];
        return;
    }


    $_SESSION['messages'] = [["text" => "Your user information updated successfully", "type" => "success"]];
    // update the stored data in $user by refreshing the page
    header('Location: /home.php');
    exit();

}

function getBlockingInfo($connection, $user_id)
{
    $currentDateTime = date("Y-m-d H:i:s");

    $query = "SELECT MAX(violation_end_datetime) FROM Violations WHERE violator_id = ? AND violation_end_datetime > ?";

    $stmt = $connection->prepare($query);
    $stmt->bind_param("is", $user_id, $currentDateTime);
    $stmt->execute();
    $stmt->bind_result($blockingEndDatetime);
    $stmt->fetch();
    $stmt->close();

    return $blockingEndDatetime;
}

function deleteCar($connection, $user)
{
    // Retrieve user_id from $user array
    $user_id = $user['user_id'];

    // Retrieve car_id from $_POST
    $car_id = isset($_POST['car_id']) ? $_POST['car_id'] : null;


    // Return if car_id is not set
    if ($car_id === null) {
        $_SESSION['messages'] = [["text" => "Please provide car_id.", "type" => "error"]];
        return;
    }

    // Check if the user is the owner of the specified car
    $ownershipCheck = $connection->prepare("SELECT COUNT(*) FROM Cars WHERE car_id = ? AND owner_id = ?");
    $ownershipCheck->bind_param("ii", $car_id, $user_id);

    // Check if the query executed successfully
    if ($ownershipCheck->execute() === FALSE) {

        $_SESSION['messages'] = [["text" => $ownershipCheck->error, "type" => "error"]];
        $ownershipCheck->close();
        return;
    }

    $ownershipCheck->bind_result($ownershipCount);
    $ownershipCheck->fetch();
    $ownershipCheck->close();

    // Return if the user is not the owner of the car
    if ($ownershipCount === 0) {
        $_SESSION['messages'] = [["text" => "You do not have permission to delete this car.", "type" => "error"]];
        return;
    }

    // Get reservations associated with the specified car_id that are still not finished
    $deleteReservationsQuery = "DELETE FROM Reservation WHERE car_id = ? AND exit_datetime IS NULL";
    $reservationsStmt = $connection->prepare($deleteReservationsQuery);
    $reservationsStmt->bind_param("i", $car_id);

    // Check if the query executed successfully
    if ($reservationsStmt->execute() === FALSE) {
        $_SESSION['messages'] = [["text" => $reservationsStmt->error, "type" => "error"]];
        $reservationsStmt->close();
        return;
    }

    $reservationsStmt->close();

    // Prepare and execute SQL statement to set the deleted flag for the car
    $deleteCarStmt = $connection->prepare("UPDATE Cars SET deleted = 1 WHERE car_id = ?");
    $deleteCarStmt->bind_param("i", $car_id);

    // Check if the query executed successfully
    if ($deleteCarStmt->execute() === TRUE) {
        $_SESSION['messages'] = [["text" => "Car and associated reservations deleted successfully!", "type" => "success"]];
        // update the stored data in $user by refreshing the page
        header('Location: /home.php');
        exit();
    } else {
        $_SESSION['messages'] = [["text" => $deleteCarStmt->error, "type" => "error"]];
    }

    // Close statements
    $deleteCarStmt->close();
}


// Function to add a new car for a user
function addCar($connection, $user)
{
    // Retrieve user_id from $user array
    $user_id = $user['user_id'];

    // Return if user_id is not present
    if (!$user_id) {
        $_SESSION['messages'] = [["text" => "Please provide user_id.", "type" => "error"]];
        return;
    }

    // Retrieve other car data from $_POST
    $car_type = $_POST['car_type'] ?? null;
    $car_plate = $_POST['car_plate'] ?? null;

    // Return if other required data are not set
    if (!$car_type || !$car_plate) {
        $_SESSION['messages'] = [["text" => "Please provide Car Type and Car Plate.", "type" => "error"]];
        return;
    }
    // Convert car plate to uppercase
    $car_plate = strtoupper($car_plate);
    // Check if the car_plate already exists in the database
    $existingCarCheck = $connection->prepare("SELECT COUNT(*) FROM Cars WHERE car_plate = ? AND deleted=FALSE");
    $existingCarCheck->bind_param("s", $car_plate);
    $existingCarCheck->execute();
    $existingCarCheck->bind_result($existingCount);
    $existingCarCheck->fetch();
    $existingCarCheck->close();

    // Return if a matching car_plate already exists
    if ($existingCount > 0) {
        $_SESSION['messages'] = [["text" => "Car with the same plate already exists.", "type" => "error"]];
        return;
    }

    // Prepare and execute SQL statement to insert a new car
    $stmt = $connection->prepare("INSERT INTO Cars (car_type, car_plate, owner_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $car_type, $car_plate, $user_id);

    // Check if the query executed successfully
    if ($stmt->execute() === TRUE) {
        $_SESSION['messages'] = [["text" => "Your car has been created.", "type" => "success"]];
        // update the stored data in $user by refreshing the page
        header('Location: /home.php');
        exit();
    } else {
        $_SESSION['messages'] = [["text" => $stmt->error, "type" => "error"]];
    }

    // Close statement
    $stmt->close();
}

function checkIn($connection, $user)
{
    // Check if user is an admin
    if ($user["user_type_id"] != 3) {
        $_SESSION['messages'] = [["text" => "You don't have permission to check in for this reservation.", "type" => "error"]];
        return;
    }

    // Check if reservation_id is provided in $_GET
    if (!isset($_GET['reservation_id'])) {
        $_SESSION['messages'] = [["text" => "Invalid reservation ID.", "type" => "error"]];
        return;
    }

    $reservation_id = $_GET['reservation_id'];

    // Check if enter_datetime is already set
    $query = "SELECT enter_datetime FROM Reservation WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $stmt->bind_result($enter_datetime);
    $stmt->fetch();
    $stmt->close();

    if ($enter_datetime !== null) {
        $_SESSION['messages'] = [["text" => "Entry datetime is already marked for this reservation.", "type" => "error"]];
        return;
    }

    // Set enter_datetime to current date and time
    $enter_datetime_now = date("Y-m-d H:i:s");
    $query = "UPDATE Reservation SET enter_datetime = ? WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("si", $enter_datetime_now, $reservation_id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['messages'] = [["text" => "Check-in successful.", "type" => "success"]];
        header("Location: $_SERVER[REQUEST_URI]"); // Redirect to the same page
        exit();
    } else {
        $_SESSION['messages'] = [["text" => "Failed to check in. Please try again.", "type" => "error"]];
    }
}


function checkOut($connection, $user)
{
    // Check if user is an admin
    if ($user["user_type_id"] != 3) {
        $_SESSION['messages'] = [["text" => "You don't have permission to check out for this reservation.", "type" => "error"]];
        return;
    }

    // Check if reservation_id is provided in $_GET
    if (!isset($_GET['reservation_id'])) {
        $_SESSION['messages'] = [["text" => "Invalid reservation ID.", "type" => "error"]];
        return;
    }

    $reservation_id = $_GET['reservation_id'];

    // Check if enter_datetime or exit_datetime is already set
    $query = "SELECT enter_datetime, exit_datetime FROM Reservation WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $stmt->bind_result($enter_datetime, $exit_datetime);
    $stmt->fetch();
    $stmt->close();

    if ($enter_datetime === null) {
        $_SESSION['messages'] = [["text" => "Enter datetime must be set before checking out.", "type" => "error"]];
        return;
    }

    if ($exit_datetime !== null) {
        $_SESSION['messages'] = [["text" => "Exit datetime is already marked for this reservation.", "type" => "error"]];
        return;
    }

    // Set exit_datetime to current date and time
    $exit_datetime_now = date("Y-m-d H:i:s");
    $query = "UPDATE Reservation SET exit_datetime = ? WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("si", $exit_datetime_now, $reservation_id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['messages'] = [["text" => "Check-out successful.", "type" => "success"]];
        header("Location: $_SERVER[REQUEST_URI]"); // Redirect to the same page
        exit();
    } else {
        $_SESSION['messages'] = [["text" => "Failed to check out. Please try again.", "type" => "error"]];
    }
}


function cancelReservation($connection, $user)
{
    // Check if reservation_id is provided in $_GET
    if (!isset($_GET['reservation_id'])) {
        $_SESSION['messages'] = [["text" => "Invalid reservation ID.", "type" => "error"]];
        return;
    }

    $reservation_id = $_GET['reservation_id'];


    // Check if the reservation belongs to the user
    $query = "SELECT reserver_id, enter_datetime, exit_datetime FROM Reservation WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $stmt->bind_result($reserver_id, $enter_datetime, $exit_datetime);
    $stmt->fetch();
    $stmt->close();

    if ($user["user_type_id"] != 3 && $reserver_id != $user["user_id"]) {
        $_SESSION['messages'] = [["text" => "You don't have permission to cancel this reservation.", "type" => "error"]];
        return;
    }

    // Check if enter_datetime or exit_datetime is set
    if ($enter_datetime !== null || $exit_datetime !== null) {
        $_SESSION['messages'] = [["text" => "Cannot cancel reservation with entry or exit datetime set.", "type" => "error"]];
        return;
    }


    $query = "DELETE FROM Reservation WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $reservation_id);
    $result = $stmt->execute();


    if ($result) {
        $_SESSION['messages'] = [["text" => "Reservation canceled successfully.", "type" => "success"]];
        header("Location: /home.php"); // Redirect to /home.php
        $stmt->close();
        exit();
    } else {
        $_SESSION['messages'] = [["text" => "Failed to cancel reservation. Error: " . $stmt->error, "type" => "error"]];
        $stmt->close();
    }
}

function rateReservation($connection, $user)
{
    // Check if user is an admin
    if ($user["user_type_id"] == 3) {
        $_SESSION['messages'] = [["text" => "You don't have permission to rate reservations.", "type" => "error"]];
        return;
    }

    // Check if reservation_id and rating are provided in $_GET and $_POST
    if (!isset($_GET['reservation_id']) || !isset($_POST['rating'])) {
        $_SESSION['messages'] = [["text" => "Invalid reservation ID or rating.", "type" => "error"]];
        return;
    }

    $reservation_id = $_GET['reservation_id'];
    $rating = $_POST['rating'];

    // Validate the rating (you may customize this based on your rating system)
    if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        $_SESSION['messages'] = [["text" => "Invalid rating. Please provide a numeric value between 1 and 5.", "type" => "error"]];
        return;
    }


    // Update the Feedback table with the provided rating
    $insertFeedbackQuery = "INSERT INTO FeedBacks (reservation_id, rating_scale) VALUES (?, ?)";
    $stmt = $connection->prepare($insertFeedbackQuery);

    // Check for errors in the query preparation
    if (!$stmt) {
        $_SESSION['messages'] = [["text" => "Error preparing statement: " . $connection->error, "type" => "error"]];
        return;
    }
    $stmt->bind_param("ii", $reservation_id, $rating);
    $result = $stmt->execute();
    $stmt->close();

    if ($result) {
        $_SESSION['messages'] = [["text" => "Rating submitted successfully.", "type" => "success"]];
        header("Location: $_SERVER[REQUEST_URI]"); // Redirect to the same page
        exit();
    } else {
        $_SESSION['messages'] = [["text" => "Failed to submit rating. Please try again.", "type" => "error"]];
    }
}

?>
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
    $emailInUseQuery = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
    $emailInUseStatement = $connection->prepare($emailInUseQuery);
    $emailInUseStatement->bind_param("si", $email, $user_id);
    $emailInUseStatement->execute();
    $emailInUseResult = $emailInUseStatement->get_result();

    if ($emailInUseResult->num_rows > 0) {
        $_SESSION['messages'] = [["text" => "Email is already in use by another user.", "type" => "error"]];
        return;
    }
    // Update user information in the database
    $updateUserQuery = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?";
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
    $ownershipCheck->execute();
    $ownershipCheck->bind_result($ownershipCount);
    $ownershipCheck->fetch();
    $ownershipCheck->close();

    // Return if the user is not the owner of the car
    if ($ownershipCount === 0) {
        $_SESSION['messages'] = [["text" => "You do not have permission to delete this car.", "type" => "error"]];
        return;
    }

    // Prepare and execute SQL statement to set the deleted flag
    $stmt = $connection->prepare("UPDATE Cars SET deleted = 1 WHERE car_id = ?");
    $stmt->bind_param("i", $car_id);

    // Check if the query executed successfully
    if ($stmt->execute() === TRUE) {
        $_SESSION['messages'] = [["text" => "Car deleted successfully!", "type" => "success"]];
        // update the stored data in $user by refreshing the page
        header('Location: /home.php');
        exit();
    } else {
        $_SESSION['messages'] = [["text" => $stmt->error, "type" => "error"]];
    }

    // Close statement
    $stmt->close();
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
<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}
?>
<?php
// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Use the existing database connection
    $user_id = $_SESSION['user_id'];

    // Prepare and execute a query to retrieve user data
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id); // Assuming user_id is an integer
    $stmt->execute();

    // Fetch the user data into an associative array
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    // Now, $user contains the user data from the database
}
<?php
// Database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "Trkeen";

// Create a new account
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST["user_id"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];  
    $password = $_POST["password"];
    $user_type = $_POST["user_type"];

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if user ID already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User ID already exists
        echo "User ID already exists. Please choose a different User ID.";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (user_id, first_name, last_name, email, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $user_id, $first_name, $last_name, $email, $password, $user_type);
        $stmt->execute();

        // Close the statement and the database connection
        $stmt->close();
        $conn->close();

        // Redirect to a success page
        header("Location: success.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>
</head>
<body>
    <h2>Create Account</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        User ID: <input type="text" name="user_id"><br><br>
        First Name: <input type="text" name="first_name"><br><br>
        Last Name: <input type="text" name="last_name"><br><br>
        Email: <input type="email" name="email"><br><br>
        Password: <input type="password" name="password"><br><br>
        User Type: <input type="text" name="user_type"><br><br>
        <input type="submit" value="Create Account">
    </form>
</body>
</html>
<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}
?>
<?php
if (!isset($_SESSION['messages']))
    $_SESSION['messages'] = [];
$HOST = "127.0.0.1";
$USERNAME = "root";
//$PASSWORD = "";
$PASSWORD = "123456";
$DATABASE_NAME = "Tarkeen";

//  Create connection
$connection = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DATABASE_NAME);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
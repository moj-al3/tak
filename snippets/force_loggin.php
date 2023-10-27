<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}
?>
<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit();
}

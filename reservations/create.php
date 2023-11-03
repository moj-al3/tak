<?php include "../snippets/base.php" ?>
<?php
require("../snippets/force_loggin.php");
if ($user["user_type_id"] != "2" && $user["user_type_id"] != "1") {
    die("Access Denied");
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Reservation</title>
</head>
<body>
<h1>Reservation Page</h1>
</body>
</html>

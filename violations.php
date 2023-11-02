<?php include "snippets/base.php" ?>
<?php
require("snippets/force_loggin.php");
if ($user["user_type_id"] != "3") {
    die("Access Denied");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carPlate = $_POST['car_plate'];
    $violationId = $_POST['violation_id'];

    // Get car_id and owner_id based on car_plate
    $carQuery = "SELECT car_id, owner_id FROM cars WHERE car_plate = ?";
    $carStatement = $connection->prepare($carQuery);
    $carStatement->bind_param("s", $carPlate);
    $carStatement->execute();
    $carResult = $carStatement->get_result();

    if ($carResult && $carResult->num_rows > 0) {
        $carData = $carResult->fetch_assoc();
        $carId = $carData['car_id'];
        $ownerId = $carData['owner_id'];

        // Get current datetime
        $violationDatetime = date('Y-m-d H:i:s');

        // Assuming violation_type_id is the same as violation_id
        $violationTypeId = $violationId;

        // Insert the violation into the violations table
        $insertViolationQuery = "INSERT INTO violations (violation_datetime, car_id, violation_type_id, violator_id, violated_id) 
                                VALUES (?, ?, ?, ?, ?)";
        $insertStatement = $connection->prepare($insertViolationQuery);
        $insertStatement->bind_param("siiii", $violationDatetime, $carId, $violationTypeId, $ownerId, $user['user_id']);
        $insertStatement->execute();

        if ($insertStatement) {
            if ($insertStatement->affected_rows > 0) {
                echo "Violation recorded successfully.";
            } else {
                echo "Error: No rows inserted. " . $connection->error;
            }
        } else {
            echo "Error: " . $connection->error;
        }
    } else {
        echo "Car with the provided plate not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Violations</title>
</head>
<body>
<form method="post">
    Car Plate: <input type="text" name="car_plate" required><br><br>
    Violation ID: <input type="text" name="violation_id" required><br><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>

<?php include "../snippets/base.php" ?>
<?php
require("../snippets/force_loggin.php");
if ($user["user_type_id"] != "3") {
    die("Access Denied");
}
// Fetch violation types with their IDs from the database
$violationTypesQuery = "SELECT violation_type_id, name,number_of_days FROM ViolationTypes";
$violationTypesResult = $connection->query($violationTypesQuery);
$violationTypes = $violationTypesResult->fetch_all(MYSQLI_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $carPlate = filter_input(INPUT_POST, 'car_plate', FILTER_SANITIZE_STRING);
    $violationId = filter_input(INPUT_POST, 'violation_id', FILTER_VALIDATE_INT);
    $note = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_STRING); // New Note field

    // Get the number_of_days for the selected violation type
    $selectedViolationTypeDays = null;
    foreach ($violationTypes as $type) {
        if ($type['violation_type_id'] == $violationId) {
            $selectedViolationTypeDays = $type['number_of_days'];
            break;
        }
    }


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

        // Calculate violation_end_datetime
        $violationEndDatetime = date('Y-m-d H:i:s', strtotime("+ $selectedViolationTypeDays days"));

        // Assuming violation_type_id is the same as violation_id
        $violationTypeId = $violationId;

        // Insert the violation into the violations table including the note and violation_end_datetime
        $insertViolationQuery = "INSERT INTO violations (violation_datetime, violation_end_datetime, car_id, violation_type_id, violator_id, violated_id, note) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertStatement = $connection->prepare($insertViolationQuery);
        $insertStatement->bind_param("ssiiiss", $violationDatetime, $violationEndDatetime, $carId, $violationId, $ownerId, $user['user_id'], $note);
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
    Violation Type:
    <select id="violation_id" name="violation_id">
        <?php
        foreach ($violationTypes as $type) {
            echo '<option value="' . $type['violation_type_id'] . '">' . $type['name'] . '</option>';
        }
        ?>
    </select><br><br>
    Note: <input type="text" name="note"><br><br>
    <input type="submit" value="Submit">
</form>
</body>
</html>

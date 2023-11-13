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
                $_SESSION['messages'] = [["text" => "Violation recorded successfully.", "type" => "success"]];
            } else {
                $_SESSION['messages'] = [["text" => "Error: No rows inserted." . $connection->error, "type" => "error"]];
            }
        } else {
            $_SESSION['messages'] = [["text" => "Error: " . $connection->error . $connection->error, "type" => "error"]];
        }
    } else {
        $_SESSION['messages'] = [["text" => "No Car with was found with the provided plate." . $connection->error, "type" => "error"]];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include "../snippets/layout/head.php" ?>
    <title>Record Violation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<?php include "../snippets/layout/header.php" ?>
<main class="mb-12">
    <h1 class="text-6xl mb-8  mt-5 text-white texe-bold">Implementing Violations</h1>
    <form class=" mb-5  flex justify-end items-center flex-col" method="post">
        <div class="w-full max-w-mds flex justify-end gap-12 items-center row">
            <div class="col-md-6 w-fulls w-5/12	">
                <div class="flex items-center border-b border-gray-500 py-2 mb-4">
                    <input class="appearance-none bg-transparent border-none  w-full text-white mr-3 py-1 px-2  focus:outline-none"
                           type="text" placeholder="Car plate*" aria-label="Full name" name="car_plate" required>
                </div>
            </div>
            <div class="col w-5/12 ">
                <?php foreach ($violationTypes as $type): ?>
                    <div class="flex items-center">
                        <input id="default-radio-<?= $type['violation_type_id'] ?>" type="radio"
                               value="<?= $type['violation_type_id'] ?>" name="violation_id">
                        <label for="default-radio-<?= $type['violation_type_id'] ?>"
                               class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><?= $type['name'] ?></label>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="flex items-center flex-col  py-2  mt-5 w-full">
            <div class="w-6/12">
                <label for="message" class="block font-medium text-sm text-gray-100">Comment</label>
                <textarea class="appearance-none bg-transparent border  w-full text-white py-1 "
                          name="note"
                          id="" cols="20" rows="3"></textarea>
            </div>
            <button class="px-5 w-60 mt-3 bg-red-500 text-gray-100 text-center rounded-xl" type="submit">Submit</button>
            <!-- <input class="appearance-none bg-transparent border-none  w-full text-white mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Car plate*" aria-label="Full name"> -->
        </div>


    </form>


</main>
<?php include "../snippets/layout/footer.php" ?>
<!-- Javascript -->
<?php include "../snippets/layout/scripts.php" ?>
<?php include "../snippets/layout/messages.php" ?>

</body>
</html>



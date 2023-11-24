<?php
function checkBeforeEnter(array $reservationResult, $connection)
{
    $waitingTime = 20 + ($reservationResult["extensions_count"] * 5);
    // Add $waitingTime minutes to the datetime
    $lastWaitingDateTime = strtotime(date('Y-m-d H:i:s', strtotime($reservationResult["reservation_datetime"] . ' + ' . $waitingTime . ' minutes')));
    // get the current DateTime
    $currentDatetime = strtotime(date('Y-m-d H:i:s'));
    // Calculate the difference in seconds
    $timeDifference = $lastWaitingDateTime - $currentDatetime;

    if ($timeDifference <= 0) {
        $query = "DELETE FROM Reservation WHERE reservation_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $reservationResult["reservation_id"]);
        if ($stmt->execute() == false) {
            exit();
        }
        // Check if we need to create a violation for him
        if ($reservationResult["extensions_count"] == 3) {
            // Get current datetime
            $violationDatetime = date('Y-m-d H:i:s');
            // Calculate violation_end_datetime
            $violationEndDatetime = date('Y-m-d H:i:s', strtotime("+ 3 days"));
            // Insert the violation into the violations table including the note and violation_end_datetime
            $insertViolationQuery = "INSERT INTO violations (violation_datetime, violation_end_datetime, car_id, violation_type_id, violator_id, violated_id) 
                                    VALUES (?, ?, ?, 3, ?, 1)";
            $insertStatement = $connection->prepare($insertViolationQuery);
            $insertStatement->bind_param("ssii", $violationDatetime, $violationEndDatetime, $reservationResult["car_id"], $reservationResult['reserver_id']);
            $insertStatement->execute();
            echo json_encode(["action" => "showBlock", "reason" => "Extended reservation 3 times and did not show"]);
            exit();
        }

        echo json_encode(["action" => "showCancel", "reason" => "Did not show to the reservation"]);
        exit();
    }
    if ($timeDifference < 300) {
        echo json_encode(["action" => "sendReminder", "reservation_id" => $reservationResult["reservation_id"], "timeLeft" => (int)round($timeDifference / 60), "extensions" => $reservationResult["extensions_count"]]);
        exit();
    }

    echo json_encode(["action" => "nothing", "timeLeft" => (int)round($timeDifference / 60)]);
    exit();
}

function checkAfterEnter(array $reservationResult, $connection)
{
    $waitingTime = $reservationResult["reservation_length"] * 60;
    // Add $waitingTime minutes to the datetime
    $lastWaitingDateTime = strtotime(date('Y-m-d H:i:s', strtotime($reservationResult["enter_datetime"] . ' + ' . $waitingTime . ' minutes')));
    // get the current DateTime
    $currentDatetime = strtotime(date('Y-m-d H:i:s'));
    // Calculate the difference in seconds
    $timeDifference = $lastWaitingDateTime - $currentDatetime;

    if ($timeDifference <= 0) {
        $query = "DELETE FROM Reservation WHERE reservation_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $reservationResult["reservation_id"]);
        if ($stmt->execute() == false) {
            exit();
        }
        // Get current datetime
        $violationDatetime = date('Y-m-d H:i:s');
        // Calculate violation_end_datetime
        $violationEndDatetime = date('Y-m-d H:i:s', strtotime("+ 1 days"));
        // Insert the violation into the violations table including the note and violation_end_datetime
        $insertViolationQuery = "INSERT INTO violations (violation_datetime, violation_end_datetime, car_id, violation_type_id, violator_id, violated_id) 
                                    VALUES (?, ?, ?, 1, ?, 1)";
        $insertStatement = $connection->prepare($insertViolationQuery);
        $insertStatement->bind_param("ssii", $violationDatetime, $violationEndDatetime, $reservationResult["car_id"], $reservationResult['reserver_id']);
        $insertStatement->execute();
        echo json_encode(["action" => "showBlock", "reason" => "Exceeding the time allowed for parking"]);
        exit();

    }
    if ($timeDifference < 300) {
        echo json_encode(["action" => "sendWarning", "timeLeft" => (int)round($timeDifference / 60)]);
        exit();
    }

    echo json_encode(["action" => "nothing", "timeLeft" => (int)round($timeDifference / 60)]);
    exit();
}


header('Content-Type: application/json; charset=utf-8');
require("../snippets/base.php");
// if the user is not logged in nor visitor kfu nor member then there is no need to continue
if (!isset($user) || ($user["user_type_id"] != 1 && $user["user_type_id"] != 2)) {
    echo json_encode(["action" => "nothing"]);
    exit();
}

// Check if the user already has an open reservation for today
$reservationSql = "SELECT *  FROM Reservation WHERE reserver_id = ? AND DATE(reservation_datetime) = CURDATE() AND exit_datetime is NULL LIMIT 1";
$reservationStmt = $connection->prepare($reservationSql);
$reservationStmt->bind_param("i", $user['user_id']);
$reservationStmt->execute();
$reservationResult = $reservationStmt->get_result()->fetch_assoc();

if (!isset($reservationResult)) {
    echo json_encode(["action" => "nothing"]);
    exit();
}


// check if the user entered the reservation
if (!isset($reservationResult["enter_datetime"])) {
    checkBeforeEnter($reservationResult, $connection);
}
// if the user is visitor then we need to do checking on him after entering
if ($user["user_type_id"] == 2) {
    checkAfterEnter($reservationResult, $connection);
}




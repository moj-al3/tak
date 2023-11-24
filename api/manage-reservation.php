<?php
function cancel($connection, $reservation_id)
{
    $query = "DELETE FROM Reservation WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $reservation_id);
    if ($stmt->execute() == false) {
        echo json_encode("Failed to cancel reservation. Error: " . $stmt->error);
        http_response_code(500);
    } else {
        echo json_encode("reservation was deleted");
    }
    exit();
}

function extend($connection, $reservation_id, $extensions_count)
{
    $extensions_count++;
    $query = "UPDATE Reservation SET extensions_count = ? WHERE reservation_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $extensions_count, $reservation_id);
    $result = $stmt->execute();
    $stmt->close();

    if ($result == false) {
        echo json_encode("Failed to extend reservation. Error: " . $stmt->error);
        http_response_code(500);
    } else {
        echo json_encode("reservation was extended");
    }
    exit();

}

header('Content-Type: application/json; charset=utf-8');
require("../snippets/base.php");
// Check if reservation_id is provided in $_GET
if (!isset($_GET['reservation_id']) || !isset($_GET['action'])) {
    echo json_encode("Invalid reservation ID or action.");
    http_response_code(500);
    exit();
}
$reservation_id = $_GET['reservation_id'];
$action = $_GET['action'];


// Check if the reservation belongs to the user
$query = "SELECT reserver_id, enter_datetime, exit_datetime,extensions_count FROM Reservation WHERE reservation_id = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $reservation_id);
$stmt->execute();
$stmt->bind_result($reserver_id, $enter_datetime, $exit_datetime, $extensions_count);
$stmt->fetch();
$stmt->close();

if ($reserver_id != $user["user_id"]) {
    echo json_encode("You don't have permission to cancel this reservation.");
    http_response_code(500);
    exit();
}

// Check if enter_datetime or exit_datetime is set
if ($enter_datetime !== null || $exit_datetime !== null) {
    echo json_encode("Cannot manage reservation with entry or exit datetime set.");
    http_response_code(500);
    exit();
}

switch ($action) {
    case "cancel":
        cancel($connection, $reservation_id);
        break;
    case "extend":
        extend($connection, $reservation_id, $extensions_count);
        break;
}




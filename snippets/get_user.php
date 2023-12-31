<?php
// Make sure this file is only included and not accessed directly
if (!defined('INCLUDED_BY_OTHER_FILE')) {
    // Display an error message or perform any desired action
    die('Access denied.');
}

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Use the existing database connection
    $user_id = $_SESSION['user_id'];

    // Retrieve user data
    $query = "SELECT * FROM Users WHERE user_id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Retrieve cars associated with the user
    $queryCars = "SELECT car_id, car_type, car_plate FROM Cars WHERE owner_id = ? and deleted=FALSE";
    $stmtCars = $connection->prepare($queryCars);
    $stmtCars->bind_param("i", $user_id);
    $stmtCars->execute();
    $resultCars = $stmtCars->get_result();
    $cars = array();
    while ($row = $resultCars->fetch_assoc()) {
        $cars[] = $row;
    }
    $stmtCars->close();

    // Add the cars information to the $user array
    $user['cars'] = $cars;

    // Retrieve reservations associated with the user
    $reservationQuery = "SELECT Reservation.reservation_id, Reservation.reservation_datetime, Reservation.extensions_count, ParkingSpots.parking_number 
                        FROM `Reservation` 
                        JOIN `ParkingSpots` ON ParkingSpots.parking_id = Reservation.parking_id 
                        WHERE Reservation.reserver_id = ? 
                        ORDER BY Reservation.reservation_datetime DESC";
    $stmtReservations = $connection->prepare($reservationQuery);
    $stmtReservations->bind_param("i", $user_id);
    $stmtReservations->execute();
    $resultReservations = $stmtReservations->get_result();
    $reservations = array();
    while ($row = $resultReservations->fetch_assoc()) {
        $reservations[] = $row;
    }
    $stmtReservations->close();

    // Add the reservations information to the $user array
    $user['reservations'] = $reservations;

    // Retrieve violations associated with the user
    // If he is a security then get the violations created by him
    if ($user["user_type_id"] == "3") {
        $vailoationQuery = "SELECT Violations.violation_id, ViolationTypes.name, Violations.violation_datetime,Violations.note, Cars.car_plate 
                        FROM `Violations` 
                        JOIN `ViolationTypes` ON ViolationTypes.violation_type_id = Violations.violation_type_id 
                        JOIN `Cars` ON Cars.car_id = Violations.car_id 
                        WHERE Violations.violated_id = ? 
                        ORDER BY Violations.violation_datetime DESC";
    } else {
        $vailoationQuery = "SELECT Violations.violation_id, ViolationTypes.name, Violations.violation_datetime,Violations.note, Cars.car_plate 
                        FROM `Violations` 
                        JOIN `ViolationTypes` ON ViolationTypes.violation_type_id = Violations.violation_type_id 
                        JOIN `Cars` ON Cars.car_id = Violations.car_id 
                        WHERE Violations.violator_id = ? 
                        ORDER BY Violations.violation_datetime DESC";
    }
    $stmtViolations = $connection->prepare($vailoationQuery);
    $stmtViolations->bind_param("i", $user_id);
    $stmtViolations->execute();
    $resultViolations = $stmtViolations->get_result();
    $violations = array();
    while ($row = $resultViolations->fetch_assoc()) {
        $violations[] = $row;
    }
    $stmtViolations->close();

    // Add the violations information to the $user array
    $user['violations'] = $violations;

    // Now, $user contains the user data from the database
}
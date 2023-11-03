<?php include "snippets/base.php" ?>
<?php
require("snippets/force_loggin.php");
// get user profile info
$selectUserQuery = "SELECT users.* ,cars.car_type,cars.car_plate,cars.car_id   FROM users , cars WHERE users.user_id=cars.owner_id AND users.user_id='$_SESSION[user_id]'";
$UsResult = $connection->query($selectUserQuery); // This line will call the database and execute the sql
if ($UsResult != false && $UsResult->num_rows == 1) {
   $row = $UsResult->fetch_assoc();
   if (isset($_POST["edit"])) {
      $carID = $row["car_id"];
      $upUserquery = "UPDATE `users` SET  `first_name`='$_POST[first_name]',`last_name`='$_POST[last_name]', `email`='$_POST[email]'  WHERE `user_id`='$_POST[user_id]'";
      $upUserResult = $connection->query($upUserquery); // This line will call the database and execute the sql

      $upCarquery = "UPDATE `cars` SET  `car_type`='$_POST[car_type]',`car_plate`='$_POST[car_plate]' WHERE `car_id`='$carID'";
      $upCarResult = $connection->query($upCarquery); // This line will call the database and execute the sql

      if ($upUserResult && $upCarResult) {
         header("Location:profile.php");
      }
   }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Styles -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <!-- <link rel="stylesheet" href="./assets/css/font-awesome-5.15.1.min.css"> -->
   <link rel="stylesheet" href="./assets/fontawesome-free-6.4.2-web/css/all.min.css">
   <link rel="stylesheet" href="./assets/css/base.css">
   <link rel="stylesheet" href="./assets/css/profilestyle.css">
   
   <!-- <link rel="stylesheet" href="./assets/css/style.css"> -->
   <title>profile</title>
   <!-- <script src="https://cdn.tailwindcss.com"></script> -->
</head>

<body class="body">
   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" 
   integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>

   <!-- <header>
      <h1>
         Profile Tarkken
      </h1>
   </header> -->
   <?php  require "header1.php" ?>
   <main>
      <div class="container-profile">
         <div class="left">
            <form action="#" method="post">
               <div class="img-container">
                  <img src="./assets/img/User-avatar.png" alt="" width="30%" height="30%">
               </div>
               <h3>My Profile</h3>
               <div class="fields">
                  <label for="">
                     <span>ID:</span>
                     <input type="text" name="user_id" value="<?php echo $row['user_id'] ?>" readonly>
                  </label>
                  <label for="">
                     <span>First Name:</span>
                     <input type="text" name="first_name" value="<?php echo $row['first_name'] ?>"readonly >
                  </label>
                  <label for="">
                     <span>Last Name:</span>
                     <input type="text" name="last_name" value="<?php echo $row['last_name'] ?>" readonly>
                  </label>
                  <label for="">
                     <span>Email:</span>
                     <input type="email" name="email" value="<?php echo $row['email'] ?>" readonly>
                  </label>
                  <label for="">
                     <span>Car Type:</span>
                     <input type="text" name="car_type" value="<?php echo $row['car_type'] ?>" readonly>
                  </label>
                  <label for="">
                     <span>Car Plate:</span>
                     <input type="text" name="car_plate" value="<?php echo $row['car_plate'] ?>" readonly>
                  </label>
                  <label for="">
                     <span>Car Type2:</span>
                     <input type="text" name="car_type" value="<?php echo $row['car_type'] ?>" readonly>
                  </label>
                  <label for="">
                     <span>Car Plate2:</span>
                     <input type="text" name="car_plate" value="<?php echo $row['car_plate'] ?>"readonly>
                  </label>
                 
               </div>
               <class="save-btn">
             <i class="fas fa-pen"></i>

               <div class="save-btn">
                  <button type="submit" name="edit">save</button>
               </div>
            </form>
            
         </div>

         <div class="right">
            <div class="reservations">
               <div class="title">
                  Reservations
               </div>
               <ul class="reservations-list">
                  <?php
                  // select reservations 
                  $reservationQuery = "SELECT reservation.reservation_id, reservation.reservation_datetime, reservation.extensions_count, parkingspots.parking_number FROM `reservation` JOIN `parkingspots` ON parkingspots.parking_id = reservation.parking_id WHERE reservation.reserver_id ='$_SESSION[user_id]' ORDER BY reservation.reservation_datetime DESC LIMIT 3";
                  $ReservResult = $connection->query($reservationQuery); // This line will call the database and execute the sql
                  if ($ReservResult != false && $ReservResult->num_rows > 0)
                     while ($reserv_row = $ReservResult->fetch_assoc()) :
                  ?>
                     <li>
                        <span><?php echo $reserv_row['parking_number']; ?></span>
                        <span><?php echo date('d F, Y h:i A', strtotime($reserv_row['reservation_datetime'])) ?></span>
                     </li>
                  <?php endwhile; ?>

               </ul>
               <div class="more">
                  <button class="more-btn reservations-more-btn">
                     more
                  </button>
               </div>
            </div>
            <div class="violation">
               <div class="title">
                  Violations
               </div>
               <ul class="violation-list">
                  <?php
                  // select vailoations 
                  $vailoationQuery = "SELECT violations.violation_id, violationtypes.name, violations.violation_datetime, cars.car_plate FROM `violations` JOIN `violationtypes` ON violationtypes.violation_type_id = violations.violation_type_id JOIN `cars` ON cars.car_id=violations.car_id WHERE violations.violator_id='$_SESSION[user_id]' ORDER BY violations.violation_datetime DESC LIMIT 3";
                  $VailResult = $connection->query($vailoationQuery); // This line will call the database and execute the sql
                  if ($VailResult != false && $VailResult->num_rows > 0)
                     while ($vail_row = $VailResult->fetch_assoc()) :
                  ?>
                     <li>
                        <span><?php echo $vail_row['name'] . '  |   '.$vail_row['car_plate'];; ?></span>
                        <span><?php echo date('d F, Y h:i A', strtotime($vail_row['violation_datetime'])) ?></span>
                     </li>
                  <?php endwhile; ?>
               </ul>
               <div class="more">
                  <button class="more-btn violation-more-btn"  >
                     more
                  </button>
               </div>
            </div>
         </div>
      </div>

      <dialog class="dialog dialog-violations">
         <div class="title">
            <span>Violation</span>
            <span class="close vio-close"><i class="fa-solid fa-xmark"></i></span>
         </div>
         <div class="cont-list">
            <ul class="dialog-list">
            <?php
                  // select vailoations 
                  $vailoationQuery = "SELECT violations.violation_id, violationtypes.name, violations.violation_datetime, cars.car_plate FROM `violations` JOIN `violationtypes` ON violationtypes.violation_type_id = violations.violation_type_id JOIN `cars` ON cars.car_id=violations.car_id WHERE violations.violator_id='$_SESSION[user_id]' ORDER BY violations.violation_datetime";
                  $VailResult = $connection->query($vailoationQuery); // This line will call the database and execute the sql
                  if ($VailResult != false && $VailResult->num_rows > 0)
                     while ($vail_row = $VailResult->fetch_assoc()) :
                  ?>
               <li>
                  <span><?php echo $vail_row['name'] . '  |   '.$vail_row['car_plate'];; ?></span>
                  <span><?php echo date('d F, Y h:i A', strtotime($vail_row['violation_datetime'])) ?></span>
               </li>
               <?php endwhile; 
               ?>
               

            </ul>
         </div>
      </dialog>

      <dialog class="dialog dialog-reservations">
         <div class="title">
            <span>Reservations</span>
            <span class="close re-close"><i class="fa-solid fa-xmark"></i></span>
         </div>
         <div class="cont-list">
            <ul class="dialog-list">
            <?php
                  // select reservations 
                  $reservationQuery = "SELECT reservation.reservation_id, reservation.reservation_datetime, reservation.extensions_count, parkingspots.parking_number FROM `reservation` JOIN `parkingspots` ON parkingspots.parking_id = reservation.parking_id WHERE reservation.reserver_id ='$_SESSION[user_id]' ORDER BY reservation.reservation_datetime";
                  $ReservResult = $connection->query($reservationQuery); // This line will call the database and execute the sql
                  if ($ReservResult != false && $ReservResult->num_rows > 0)
                     while ($reserv_row = $ReservResult->fetch_assoc()) :
                  ?>
               <li>
                  <span><?php echo $reserv_row['parking_number']; ?></span>
                  <span><?php echo date('d F, Y h:i A', strtotime($reserv_row['reservation_datetime'])) ?></span>
               </li>
               <?php endwhile; ?>

            </ul>
         </div>
      </dialog>
   </main>
   <?php require "footer1.php" ?>
   <script src="./assets/js/profile-tarkken.js"></script>

</body>

</html>
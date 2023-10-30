<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
    <!-- Styles -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="/assets/css/font-awesome-5.15.1.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/violation.css">
</head>

<body>
<?php require "base.php" ?>
  <div class="container">
    <form action="/action_page.php" class="violation-form">

      <div class="vio-input">
      <label for="fname">Parking number*</label>
      <input type="text" id="fname" name="Parking number*" placeholder="Parking number*">

      <label for="fname">Car plate*</label>
      <input type="text" id="lname" name="Car plate*" placeholder="Car plate*">
      </div>

      <div class="vio-types">
      <label for="Violations type">Violations type</label>
      <select id="Violations type" name="Violations type">
        <option value="Exceeding the time allowed for parking .">Exceeding the time allowed for parking .</option>
        <option value="Parked on a wrong parking .">Parked on a wrong parking .</option>
        <option value="Parked for full day .">Parked for full day .</option>
      </select>
      </div>

      <input type="submit" value="Submit">
    </form>
  </div>

</body>

</html>
<?php
  $HOST="127.0.0.1";
  $USERNAME="root";
  $PASSWORD="";
  $DATABASE_NAME="Tarkeen";

//  Create connection
$connection = mysqli_connect($HOST,$USERNAME,$PASSWORD,$DATABASE_NAME) ;

// Check connection
if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}
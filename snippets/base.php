<!-- This file will work as a base for anything we want to include in all the files-->
<?php
// This will act as flag to tell the next include/require that they are being included by other file
const INCLUDED_BY_OTHER_FILE = true;
session_start();
include "database_connection.php";
include "get_user.php";
include "validators.php";

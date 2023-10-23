<?php
session_start();
if (!isset($_SESSION['messages']))
    $_SESSION['messages'] = [];
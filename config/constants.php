<?php

    // START SESSION
    session_start();

    // CREATE CONSTANTS TO STORE NON-REPEATING VALUES

    define('SITEURL', 'http://localhost:8080/food-order/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-order');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); // DATABASE CONNECTION
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error()); // SELECTING DATABASE


?>
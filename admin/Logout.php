<?php

    include('../config/constants.php');
    // DELETE ALL THE SESSION
    session_destroy(); // UNSETS $_SESSION['USER']

    // REDIRECT TO LOGIN PAGE
    header('location:'.SITEURL.'admin/login.php');
?>
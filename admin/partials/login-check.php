<?php

    // AUTHORIZATION - ACCESS CONTROL
    // CHECK WHETHER THE USER IS LOGIN OR NOT
    if(!isset($_SESSION['user'])) // IF USER SESSION IS NOT SET
    {
        // USER IS NOT LOG IN
        // REDIRECT TO LOGIN PAGE
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Dashboard.</div>";
        // REDIRECT TO LOGIN PAGE
        header('location:'.SITEURL.'admin/login.php');
    }

?>
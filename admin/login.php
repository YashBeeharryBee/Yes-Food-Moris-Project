<?php include('../config/constants.php')?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <div class="login ">
        <h1 class="text-center">Login</h1>
        <br>

        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset ($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset ($_SESSION['no-login-message']);
            }
        ?>
        <br>

        <!-- Login Form Start-->
         <form action="" method="POST" class="text-center">
            Username: </br>
            <input type="text" name="username" placeholder="Enter Username"> </br><br>
            Password: </br>
            <input type="text" name="password" placeholder="Enter Password">
            <br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary"> 
         </form>
         </br><br>
         <!-- Login Form end-->

        <p class="text-center">Created By - <a href="#" target="_blank">Yash Beeharry</a></p>
    </div>
</body>
</html>

<?php

    // CHECK WHETHER THE SUBMIT BUTTON IS CLICKED OR NOT

    if(isset($_POST['submit'])){
        // GET THE DATE FORM LOGIN FORM
        // $username = $_POST['username'];
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        // $password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));


        // SQL TO CHECK WHETHER THE USER WITH USERNAME AND PASSWORD EXITS OR NOT
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password='$password'";

        // EXECUTE THE QUERY
        $res = mysqli_query($conn, $sql);

        // COUNT ROWS TO CHECK WHETHER THE USER EXISTS OR NOT
        $count = mysqli_num_rows($res);

        if($count==1){
            // USER AVAILABLE
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = $username;

            // REDIRECT TO DASHBOARD
            header('location:'.SITEURL.'admin/');
        }
        else{
            //USER NOT AVAILABLE
            $_SESSION['login'] = "<div class='error text-center'>Incorrect Username and Password</div>";
            // REDIRECT TO DASHBOARD
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>
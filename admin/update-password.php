<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>CHANGE - PASSWORD</h1>
            <br /><br />

            <?php
                if(isset($_GET['id']))
                {
                    $id = $_GET['id'];
                }
            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Current Password: </td>
                        <td>
                            <input type="password" name="current_password" placeholder="Enter your current password">
                        </td>
                    </tr>

                    <tr>
                        <td>New Password: </td>
                        <td>
                            <input type="password" name="new_password" placeholder="Enter your new password">
                        </td>
                    </tr>

                    <tr>
                        <td>Confirm Password: </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm your new password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

<?php
    // CHECK WHETHER THE SUBMIT BUTTON IS CLICKED OR NOT
    if(isset($_POST['submit']))
    {
        // echo "Button Clicked";
        // GET THE DATA FROM FORM
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // CHECK WHETHER THE USER WITH CURRENT ID AND CURRENT PASSWORD EXISTS OR NOT
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        // EXECUTE THE QUERY
        $res = mysqli_query($conn, $sql);

        if($res==true)
        {
            // CHECK WHETHER DATA IS AVAILABLE OR NOT
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                // USER EXISTS AND PASSWORD CAN BE CHANGED
                // echo "User Found";

                // CHECK WHETHER THE NEW PASSWORD AND CONFIRM PASSWORD MATCH OR NOT
                if($new_password==$confirm_password)
                {
                    // echo "Password Match";

                    // UPDATE THE PASSWORD
                    $sql2 = "UPDATE tbl_admin SET 
                        password='$new_password' 
                        WHERE id=$id
                    ";

                    // EXECUTE THE QUERY
                    $res2 = mysqli_query($conn, $sql2);

                    // CHECK WHETHER THE QUERY EXECUTED OR NOT
                    if($res2==true)
                    {
                        // DISPLAY SUCCESS MESSAGE
                        $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                        // REDIRECT PAGE TO MANAGE ADMIN
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                    else
                    {
                        // DISPLAY ERROR MESSAGE
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                        // REDIRECT PAGE TO MANAGE ADMIN
                        header("location:".SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    // REDIRECT TO MANAGE ADMIN WITH ERROR MESSAGE
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match.</div>";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                // USER DOES NOT EXIST SET MESSAGE AND REDIRECT
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found.</div>";
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }

        // CHECK WHETHER THE NEW PASSWORD AND CONFIRM PASSWORD MATCH OR NOT

        // UPDATE THE PASSWORD IF ALL ABOVE IS TRUE
    }
?>


<?php include('partials/footer.php'); ?>
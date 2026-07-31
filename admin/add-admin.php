<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>ADD - ADMIN</h1>

            <br /><br /><br />

            <?php
                if(isset($_SESSION['add'])) // CHECKING WHETHER THE SESSION IS SET OR NOT
                {
                    echo $_SESSION['add']; // DISPLAYING SESSION MESSAGE IF SET
                    unset($_SESSION['add']); // REMOVING SESSION MESSAGE
                }
            ?>

            <form action="#" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Full Name: </td>
                        <td>
                            <input type="text" name="full_name" placeholder="Enter your name">
                        </td>
                    </tr>

                    <tr>
                        <td>Username: </td>
                        <td>
                            <input type="text" name="username" placeholder="Your username">
                        </td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td>
                            <input type="password" name="password" placeholder="Your password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

<?php include('partials/footer.php'); ?>

<?php
    // PROCESS THE VALUE FROM FORM AND SAVE IT IN DATABASE
    // CHECK WHETHER THE SUBMIT BUTTON IS CLICKED OR NOT

    if(isset($_POST['submit']))
    {
        // Button Clicked
        // echo "Button Clicked";

        // Get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); // Password Encryption with MD5

        // SQL Query to save the data into database
        $sql = "INSERT INTO tbl_admin SET 
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        // EXECUTE QUERY AND SAVE DATA INTO DATABASE
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // // CHECK WHETHER THE (QUERY IS EXECUTED) DATA IS INSERTED OR NOT AND DISPLAY APPROPRIATE MESSAGE
        if($res==TRUE)
        {
            // DATA INSERTED
            //echo "Data Inserted";

            // CREATE A SESSION VARIABLE TO DISPLAY SUCCESSFUL MESSAGE
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";

            // REDIRECT PAGE TO MANAGE ADMIN
            header("location:".SITEURL.'admin/manage-admin.php');

        }
        else
        {
            // FAILED TO INSERT DATA
            //echo "Failed to Insert Data";

            // CREATE A SESSION VARIABLE TO DISPLAY SUCCESSFUL MESSAGE
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin. Try Again.</div>";

            // REDIRECT PAGE TO MANAGE ADMIN
            header("location:".SITEURL.'admin/add-admin.php');

        }

    }
?>
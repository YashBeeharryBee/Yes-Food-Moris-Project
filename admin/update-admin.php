<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>UPDATE - ADMIN</h1>

        <br /><br />

        <?php
        
            // GET THE ID OF SELECTED ADMIN
            $id = $_GET['id'];

            // CREATE SQL QUERY TO GET THE DETAILS
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            // EXECUTE THE QUERY
            $res = mysqli_query($conn, $sql);

            // CHECK WHETHER THE QUERY IS EXECUTED OR NOT
            if($res==true)
            {
                // CHECK WHETHER THE DATA IS AVAILABLE OR NOT
                $count = mysqli_num_rows($res);

                // CHECK WHETHER WE HAVE ADMIN DATA OR NOT
                if($count==1)
                {
                    // GET THE DETAILS
                    // echo "Admin Available";
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else
                {
                    // REDIRECT TO MANAGE ADMIN PAGE
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        
        ?>

        <br /><br />
        
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>" placeholder="Enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Your username">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
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
        // GET ALL THE VALUES FROM FORM TO UPDATE
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        // CREATE SQL QUERY TO UPDATE ADMIN
        $sql = "UPDATE tbl_admin SET
            full_name = '$full_name',
            username = '$username' 
            WHERE id='$id'
        ";

        // EXECUTE THE QUERY
        $res = mysqli_query($conn, $sql);

        // CHECK WHETHER THE QUERY EXECUTED SUCCESSFULLY OR NOT
        if($res==true)
        {
            // QUERY EXECUTED AND ADMIN UPDATED
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully</div>";
            // REDIRECT TO MANAGE ADMIN PAGE
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // FAILED TO UPDATE ADMIN
            $_SESSION['update'] = "<div class='error'>Failed to Update Admin. Try Again.</div>";
            // REDIRECT TO MANAGE ADMIN PAGE
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

?>

<?php include ('partials/footer.php'); ?>
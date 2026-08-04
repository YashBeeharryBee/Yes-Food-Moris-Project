<?php include('partials/menu.php'); ?>
    
    <!-- Main Content Section start -->
    <div class="main-content">
        <div class="wrapper">
            <h1>MANAGE - ADMIN</h1>
            <br /><br />
            <!-- BUTTON TO ADD ADMIN -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            
            <br /><br />

            <?php
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add']; // DISPLAY SESSION MESSAGE
                    unset($_SESSION['add']); // REMOVE SESSION MESSAGE
                }
                
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete']; // DISPLAY SESSION MESSAGE
                    unset($_SESSION['delete']); // REMOVE SESSION MESSAGE
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update']; // DISPLAY SESSION MESSAGE
                    unset($_SESSION['update']); // REMOVE SESSION MESSAGE
                }

                if(isset($_SESSION['user-not-found']))
                {
                    echo $_SESSION['user-not-found']; // DISPLAY SESSION MESSAGE
                    unset($_SESSION['user-not-found']); // REMOVE SESSION MESSAGE
                }

                if(isset($_SESSION['pwd-not-match']))
                {
                    echo $_SESSION['pwd-not-match']; // DISPLAY SESSION MESSAGE
                    unset($_SESSION['pwd-not-match']); // REMOVE SESSION MESSAGE
                }

                if(isset($_SESSION['change-pwd']))
                {
                    echo $_SESSION['change-pwd']; // DISPLAY SESSION MESSAGE
                    unset($_SESSION['change-pwd']); // REMOVE SESSION MESSAGE
                }

            ?>
            

            <br /><br />

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>

                <?php
                    // QUERY TO GET ALL ADMIN
                    $sql = "SELECT * FROM tbl_admin"; // QUERY TO GET ALL ADMIN
                    // EXECUTE QUERY
                    $res = mysqli_query($conn, $sql);

                    // CHECK WHETHER THE QUERY IS EXECUTED OR NOT
                    if($res==TRUE)
                        {
                            // COUNT ROWS TO CHECK WHETHER WE HAVE DATA IN DATABASE OR NOT
                            $count = mysqli_num_rows($res); // FUNCTION TO GET ALL THE ROWS IN DATABASE

                            $sn=1; // CREATE A VARIABLE AND ASSIGN THE VALUE

                            // CHECK THE NUM OF ROWS
                            if($count>0)
                            {
                                // WE HAVE DATA IN DATABASE
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    // USING WHILE LOOP TO GET ALL THE DATA FROM DATABASE
                                    // AND WHILE LOOP WILL RUN AS LONG AS WE HAVE DATA IN DATABASE

                                    // GET INDIVIDUAL DATA
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    // DISPLAY THE VALUES IN OUR TABLE
                                    ?>
                                        <tr>
                                            <td><?php echo $sn++; ?>. </td>
                                            <td><?php echo $full_name; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td>
                                                <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change password</a>
                                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                            </td>
                                        </tr>

                                    <?php
                                }
                            }
                            else
                            {
                                // WE DO NOT HAVE DATA IN DATABASE
                            }
                        }
                ?>

            </table>
        </div>
    </div>
    <!-- Main Content Section end -->

<?php include('partials/footer.php'); ?>
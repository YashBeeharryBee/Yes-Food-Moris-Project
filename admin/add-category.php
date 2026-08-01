<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>ADD - CATEGORY</h1>

            <br /><br />

            <!-- ADD CATEGORY FORM START -->
            <?php
            
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add']; // DISPLAYING SESSION MESSAGE
                unset($_SESSION['add']); // REMOVING SESSION MESSAGE
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload']; // DISPLAYING SESSION MESSAGE
                unset($_SESSION['upload']); // REMOVING SESSION MESSAGE
            }

            ?>

            <br /><br />

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" placeholder="Enter Category Title">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
            <!-- ADD CATEGORY FORM END  -->


            <!-- CHECK WHETHER THE SUBMIT BUTTON IS CLICKED OR NOT -->
            <?php
                if(isset($_POST['submit']))
                {
                    // GET THE VALUE FROM THE CATEGORY FORM
                    $title = $_POST['title'];
                    
                    // FOR RADIO INPUT, WE NEED TO CHECK WHETHER THE BUTTON IS SELECTED OR NOT
                    if(isset($_POST['featured']))
                    {
                        // GET THE VALUE FROM FORM
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        // SET THE DEFAULT VALUE
                        $featured = "No";
                    }
                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }
                    else
                    {
                        $active = "No";
                    }

                    // CHECK IF THE IMAGE IS SELECTED OR NOT
                    if(isset($_FILES['image']['name']))
                    {
                        // GET THE DETAILS OF THE SELECTED IMAGE
                        $image_name = $_FILES['image']['name'];
                        // AUTO RENAME OUR IMAGE
                        // GET THE EXTENSION OF OUR IMAGE (jpg, png, gif, etc.) "
                        $ext = end(explode('.', $image_name));
                        // RENAME THE IMAGE
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. Food_Category_834.jpg
                        
                        
                        
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;
                        
                        // FINALLY UPLOAD THE IMAGE
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // CHECK WHETHER THE IMAGE IS UPLOADED OR NOT
                        if($upload==FALSE)
                        {
                            // SET MESSAGE
                            $_SESSION['upload'] = "<div class='error'>Image Failed to upload.</div>";
                            // REDIRECT TO ADD CATEGORY PAGE
                            header("location:".SITEURL.'admin/add-category.php');
                            // STOP THE PROCESS
                            die();
                        }
                    }
                    else
                    {
                        // NOT SELECTED
                        $image_name = ""; // SET DEFAULT VALUE AS BLANK
                    }

                    // CREATE SQL QUERY TO INSERT CATEGORY INTO DATABASE
                    $sql = "INSERT INTO tbl_category SET
                        title = '$title',
                        image_name = '$image_name',
                        featured = '$featured',
                        active = '$active'
                    ";

                    // Execute the query and save in database
                    $res = mysqli_query($conn, $sql);


                    // CHECK IF THE QUERY IS EXECUTED OR NOT AND DATA INSERTED OR NOT
                    if($res==TRUE)
                    {
                        // QUERY EXECUTED AND CATEGORY ADDED
                        $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                        // REDIRECT PAGE TO MANAGE CATEGORY
                        header("location:".SITEURL.'admin/manage-category.php');
                    }
                    else
                    {
                        // FAILED TO ADD CATEGORY
                        $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                        // REDIRECT PAGE TO MANAGE CATEGORY
                        header("location:".SITEURL.'admin/manage-category.php');
                    }
                }
            ?>

            
        </div>
    </div>

<?php include('partials/footer.php'); ?>
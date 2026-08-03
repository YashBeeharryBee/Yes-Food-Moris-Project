<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE - CATEGORY</h1>

        <br /><br /><br />

        <?php
        
            // CHECK IF THE ID IS SET OR NOT
            if(isset($_GET['id']))
            {
                // GET THE ID AND ALL OTHER DETAILS
                $id = $_GET['id'];

                // SQL QUERY TO GET SELECTED CATEGORY
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                // EXECUTE THE QUERY
                $res = mysqli_query($conn, $sql);

                // COUNT ROWS TO CHECK WHETHER THE ID IS VALID OR NOT
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    // GET ALL DATA
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {
                    // REDIRECT TO MANAGE CATEGORY WITH SESSION MESSAGE
                    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                // REDIRECT TO MANAGE CATEGORY
                header('location:'.SITEURL.'admin/manage-category.php');
            }

        ?>

        
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image!="")
                            {
                                // DISPLAY THE IMAGE
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                // DISPLAY MESSAGE
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes") { echo "checked"; } ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No") { echo "checked"; } ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes") { echo "checked"; } ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php if($active=="No") { echo "checked"; } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        
        if(isset($_POST['submit']))
        {
            // GET ALL THE VALUES FROM FORM
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // UPDATING NEW IMAGE IF SELECTED
            // CHECK WHETHER THE IMAGE IS SELECTED OR NOT
            if(isset($_FILES['image']['name']))
            {
                // GET THE IMAGE DETAILS
                $image_name = $_FILES['image']['name'];

                // CHECK WHETHER THE IMAGE IS SELECTED OR NOT
                if($image_name!="")
                {
                    // UPLOAD THE NEW IMAGE
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
                        header("location:".SITEURL.'admin/manage-category.php');
                        // STOP THE PROCESS
                        die();
                    }

                    // REMOVE THE OLD IMAGE IF AVAILABLE
                    if($current_image!="")
                    {
                        $remove_path = "../images/category/".$current_image;
                        $remove = unlink($remove_path);

                        // CHECK WHETHER THE IMAGE IS REMOVED OR NOT
                        if($remove==FALSE)
                        {
                            // FAILED TO REMOVE IMAGE
                            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                            header("location:".SITEURL.'admin/manage-category.php');
                            die(); // STOP THE PROCESS
                        }
                    }
                }
                else
                {
                    $image_name = $current_image;
                }
            }
            else
            {
                $image_name = $current_image;
            }

            // UPDATE THE DATABASE
            $sql2 = "UPDATE tbl_category SET 
            title='$title',
            image_name='$image_name',
            featured='$featured', 
            active='$active' 
            WHERE id=$id
            ";

            // EXECUTE THE QUERY
            $res2 = mysqli_query($conn, $sql2);

            // REDIRECT TO MANAGE CATEGORY WITH MESSAGE
            // CHECK WHETHER THE QUERY IS EXECUTED OR NOT
            if($res2==true)
            {
                // QUERY EXECUTED AND CATEGORY UPDATED
                $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                // REDIRECT TO MANAGE CATEGORY PAGE
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {
                // FAILED TO UPDATE CATEGORY
                $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                //REDIRECT TO MANAGE CATEGORY PAGE
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }
        
        ?>

        
    </div>
</div>

<?php include('partials/footer.php'); ?>
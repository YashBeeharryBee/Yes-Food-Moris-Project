<?php include('partials/menu.php'); ?>

<?php

    // CHECK WHETHER THE ID IS SET OR NOT
    if(isset($_GET['id']))
    {
        // GET THE ID AND ALL OTHER DETAILS
        $id = $_GET['id'];

        // SQL QUERY TO GET THE SELECTED FOOD
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        // EXECUTE THE QUERY
        $res2 = mysqli_query($conn, $sql2);

        // GET THE VALUE BASED ON QUERY EXECUTION
        $row2 = mysqli_fetch_assoc($res2);

        // GET INDIVIDUAL VALUES OF SELECTED FOOD
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        // REDIRECT TO MANAGE FOOD PAGE
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>UPDATE FOOD</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if($current_image != "")
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="Food Image" width="150px">
                            <?php
                        }
                        else
                        {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/" alt="No Image Available" width="150px">
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Selected New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php
                                // CREATE PHP CODE TO DISPLAY CATEGORIES FROM DATABASE
                                // CREATE SQL TO GET ALL ACTIVE CATEGORIES FROM DATABASE
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                $res = mysqli_query($conn, $sql);

                                // COUNT ROWS TO CHECK WHETHER WE HAVE CATEGORIES OR NOT
                                $count = mysqli_num_rows($res);

                                // IF COUNT IS GREATER THAN ZERO, WE HAVE CATEGORIES ELSE WE DONT HAVE CATEGORIES
                                if($count>0)
                                {
                                    // WE HAVE CATEGORIES
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        // GET THE DETAILS OF CATEGORIES
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];

                                        // DISPLAY ON DROPDOWN
                                        ?>
                                        <option <?php if($current_category==$category_id) { echo "selected"; } ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    // WE DO NOT HAVE CATEGORIES
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }

                            ?>
                        </select>
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
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php

            // CHECK WHETHER THE SUBMIT BUTTON IS CLICKED OR NOT
            if(isset($_POST['submit']))
            {
                // GET ALL THE VALUES FROM FORM
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

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
                        // IMAGE IS SELECTED
                        // RENAME THE IMAGE

                        $temp = explode('.', $image_name);
                        $ext = end($temp);

                        // IF THE ABOVE DOES NOT WORK COMMENT AND UNCOMMENT THE BELOW LINE

                        // $ext = pathinfo($image_name, PATHINFO_EXTENSION);

                        // THE ORIGINAL CODE
                        // $ext = end(explode('.', $image_name));

                        $image_name = "Food-Name-".rand(0000, 9999).".".$ext;

                        // UPLOAD THE IMAGE
                        $src_path = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        $upload = move_uploaded_file($src_path, $dest_path);

                        // CHECK WHETHER THE IMAGE IS UPLOADED OR NOT
                        if($upload==false)
                        {
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }

                        // REMOVE THE CURRENT IMAGE IF AVAILABLE
                        if($current_image!="")
                        {
                            $remove_path = "../images/food/".$current_image;
                            $remove = unlink($remove_path);

                            if($remove==false)
                            {
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
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

                // UPDATE THE FOOD IN DATABASE
                $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                $res3 = mysqli_query($conn, $sql3);

                // CHECK WHETHER THE QUERY IS EXECUTED OR NOT
                if($res3==true)
                {
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }

        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
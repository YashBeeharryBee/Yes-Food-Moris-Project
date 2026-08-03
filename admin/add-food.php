<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>ADD - FOOD</h1>

            <br /><br />

            <?php
            
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }

            ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Title of Food">
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of Food."></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">

                                <?php

                                    // TO DISPLAY CATEGORIES FROM DATABASE
                                    // 1. CREATE SQL TO GET ALL ACTIVE CATEGORIES FROM DATABASE
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    // EXECUTE THE QUERY
                                    $res = mysqli_query($conn, $sql);
                                    // COUNT ROWS TO CHECK WHETHER WE HAVE CATEGORIES OR NOT
                                    $count = mysqli_num_rows($res);

                                    // IF COUNT IS GREATER THAN ZERO, WE HAVE CATEGORIES ELSE WE DON'T HAVE CATEGORIES
                                    if($count>0)
                                    {
                                        // WE HAVE CATEGORIES
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            // GET THE DETAILS OF CATEGORIES
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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

                                    // DISPLAY CATEGORIES IN DROPDOWN

                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>

            <?php

                // CHECK WHETHER THE BUTTON IS CLICKED OR NOT
                if(isset($_POST['submit']))
                {
                    // GET THE DATA FROM FORM
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];

                    // CHECK WHETHER RADIO BUTTON FOR FEATURED AND ACTIVE ARE SELECTED OR NOT
                    if(isset($_POST['featured']))
                    {
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        $featured = "No"; // SET DEFAULT VALUE
                    }
                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }
                    else
                    {
                        $active = "No"; // SET DEFAULT VALUE
                    }

                    // UPLOAD THE IMAGE IF SELECTED
                    // CHECK WHETHER THE SELECT IMAGE IS CLICKED OR NOT AND UPLOAD THE IMAGE ONLY IF THE IMAGE IS SELECTED
                    if(isset($_FILES['image']['name']))
                    {
                        // GET THE DETAILS OF SELECTED IMAGE
                        $image_name = $_FILES['image']['name'];

                        // CHECK WHETHER THE IMAGE IS SELECTED OR NOT AND UPLOAD IMAGE ONLY IF SELECTED
                        if($image_name!="")
                        {
                            // IMAGE IS SELECTED
                            // RENAME THE IMAGE
                            $ext = end(explode('.', $image_name)); // GET THE EXTENSION OF SELECTED IMAGE

                            // CREATE NEW NAME FOR IMAGE
                            $image_name = "Food-Name-".rand(0000, 9999).".".$ext; // NEW IMAGE NAME MAY BE "Food-Name-657.jpg"

                            $source_path = $_FILES['image']['tmp_name']; // SOURCE PATH OF THE IMAGE
                            $dst = "../images/food/".$image_name; // DESTINATION PATH FOR THE IMAGE

                            // FINALLY UPLOAD THE FOOD IMAGE
                            $upload = move_uploaded_file($source_path, $dst);

                            // CHECK WHETHER THE IMAGE IS UPLOADED OR NOT
                            if($upload==false)
                            {
                                // FAILED TO UPLOAD THE IMAGE
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                                header("location:".SITEURL.'admin/add-food.php');
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = ""; // SET DEFAULT VALUE AS BLANK
                    }

                    // INSERT INTO DATABASE

                    //CREATE SQL QUERY TO SAVE OR ADD FOOD
                    $sql2 = "INSERT INTO tbl_food SET
                        title='$title',
                        description='$description',
                        price=$price,
                        image_name='$image_name',
                        category_id=$category,
                        featured='$featured',
                        active='$active'
                    ";

                    // EXECUTE THE QUERY
                    $res2 = mysqli_query($conn, $sql2);

                    // CHECK WHETHER DATA INSERTED OR NOT
                    // REDIRECT TO MANAGE FOOD PAGE WITH MESSAGE (SUCCESS/ERROR)
                    if($res2==true)
                    {
                        // DATA INSERTED SUCCESSFULLY
                        $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                        header("location:".SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        // FAILED TO INSERT DATA
                        $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                        header("location:".SITEURL.'admin/manage-food.php');
                    }
                }
            
            ?>

        </div>
    </div>
<?php include('partials/footer.php'); ?>
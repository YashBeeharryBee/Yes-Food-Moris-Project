<?php include('partials/menu.php'); ?>


<!-- Main Content Section start -->
<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE - FOOD</h1>

        <br /><br />

        <!-- BUTTON TO ADD FOOD -->
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

        <br /><br /><br>
        
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            if(isset($_SESSION['unauthorized']))
            {
                echo $_SESSION['unauthorized'];
                unset($_SESSION['unauthorized']);
            }
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Action</th>
            </tr>

            <?php
            
                // SQL QUERY TO GET ALL THE FOOD
                $sql = "SELECT * FROM tbl_food";

                // EXECUTE THE QUERY
                $res = mysqli_query($conn, $sql);

                // COUNT ROWS TO CHECK WHETHER WE HAVE FOOD OR NOT
                $count = mysqli_num_rows($res);

                $sn=1; // CREATE SERIAL NUMBER VARIABLE AND SET DEFAULT VALUE AS 1

                if($count>0)
                {
                    // WE HAVE FOOD IN DATABASE
                    // GET THE FOOD FROM DATABASE AND DISPLAY
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>

                            <tr>
                                <td><?php echo $sn++; ?>.</td> 
                                <td><?php echo $title; ?></td>
                                <td>Rs <?php echo $price; ?></td>
                                <td>
                                    <?php 
                                        // CHECK WHETHER WE HAVE IMAGE OR NOT
                                        if($image_name=="")
                                        {
                                            // WE DO NOT HAVE IMAGE, DISPLAY ERROR MESSAGE
                                            echo "<div class='error'>Image Not Added.</div>";
                                        }
                                        else
                                        {
                                            // WE HAVE IMAGE, DISPLAY IMAGE
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="150px">
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                                </td>
                            </tr>

                        <?php                        
                    }
                }
                else
                {
                    // FOOD NOT ADDED IN DATABASE
                    echo "<tr><td colspan='7' class='error'>Food Not Added Yet.</td></tr>";
                }

            ?>
        </table>

    </div>
</div>
<!-- Main Content Section end -->


<?php include('partials/footer.php'); ?>
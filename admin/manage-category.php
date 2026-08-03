<?php include('partials/menu.php'); ?>


<!-- Main Content Section start -->
<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE - CATEGORY</h1>

        <br /><br /><br />

        <?php
             
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add']; // DISPLAYING SESSION MESSAGE
            unset($_SESSION['add']); // REMOVING SESSION MESSAGE
        }
        if(isset($_SESSION['remove']))
        {
            echo $_SESSION['remove']; // DISPLAYING SESSION MESSAGE
            unset($_SESSION['remove']); // REMOVING SESSION MESSAGE
        }
        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete']; // DISPLAYING SESSION MESSAGE
            unset($_SESSION['delete']); // REMOVING SESSION MESSAGE
        }
        if(isset($_SESSION['no-category-found']))
        {
            echo $_SESSION['no-category-found']; // DISPLAYING SESSION MESSAGE
            unset($_SESSION['no-category-found']); // REMOVING SESSION MESSAGE
        }
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update']; // DISPLAYING SESSION MESSAGE
            unset($_SESSION['update']); // REMOVING SESSION MESSAGE
        }
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload']; // DISPLAYING SESSION MESSAGE
            unset($_SESSION['upload']); // REMOVING SESSION MESSAGE
        }
        if(isset($_SESSION['failed-remove']))
        {
            echo $_SESSION['failed-remove']; // DISPLAYING SESSION MESSAGE
            unset($_SESSION['failed-remove']); // REMOVING SESSION MESSAGE
        }

        ?>
        <br /><br /><br />

            <!-- BUTTON TO ADD ADMIN -->
            <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>

            <br /><br /><br />

            <table class="tbl-full">
                <tr>
                    <th>S.N</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php

                    // QUERY TO GET ALL CATEGORIES FROM DATABASE
                    $sql = "SELECT * FROM tbl_category";

                    //EXECUTE THE QUERY
                    $res = mysqli_query($conn, $sql);

                    // COUNT THE ROWS TO CHECK WHETHER WE HAVE CATEGORIES OR NOT
                    $count = mysqli_num_rows($res);

                    // CREATE SERIAL NUMBER VARIABLE AND SET DEFAULT VALUE AS 1
                    $sn=1;

                    // CHECK WHETHER WE HAVE CATEGORIES OR NOT
                    if($count>0)
                    {
                        // WE HAVE DATA IN DATABASE
                        // GET DATA AND DISPLAY
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $id = $row['id'];
                            $title = $row['title'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];

                            ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td>
                                    <?php
                                    // CHECK IF IMAGE NAME IS AVAILABLE OR NOT
                                    if($image_name!="")
                                    {
                                        // DISPLAY THE IMAGE
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="150px">
                                        <?php
                                    }
                                    else
                                    {
                                        // DISPLAY THE MESSAGE
                                        echo "<div class='error'>Image Not Available.</div>";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary">Update Category</a>
                                    <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Category</a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        // WE DO NOT HAVE DATA IN DATABASE
                        // DISPLAY MESSAGE INSIDE TABLE
                        ?>
                            <tr>
                                <td colspan="6"><div class="error">No Categories Found.</div></td>
                            </tr>
                        <?php
                    }
                ?>

                

            </table>

    </div>
</div>
<!-- Main Content Section end -->


<?php include('partials/footer.php'); ?>
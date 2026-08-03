<?php 

    // INCLUDE CONSTANTS.PHP FOR SITEURL
    include('../config/constants.php');

    // CHECK WHETHER THE ID AND IMAGE_NAME IS SET OR NOT
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // GET THE VALUE AND DELETE
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // REMOVE THE IMAGE IF AVAILABLE
        if($image_name!="")
        {
            // IMAGE IS AVAILABLE. SO REMOVE IT
            $path = "../images/food/".$image_name;

            // REMOVE THE IMAGE
            $remove = unlink($path);

            // CHECK WHETHER THE IMAGE IS REMOVED OR NOT
            if($remove==false)
            {
                // FAILED TO REMOVE IMAGE
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
                // REDIRECT TO MANAGE FOOD PAGE
                header('location:'.SITEURL.'admin/manage-food.php');
                // STOP THE PROCESS
                die();
            }
        }

        // DELETE DATA FROM DATABASE
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        // EXECUTE THE QUERY
        $res = mysqli_query($conn, $sql);

        // CHECK WHETHER THE DATA IS DELETED FROM DATABASE OR NOT
        if($res==true)
        {
            // SET SUCCESS MESSAGE AND REDIRECT
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // SET FAIL MESSAGE AND REDIRECT
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        echo "Delete Food Page";
    }
    else
    {
        // REDIRECT TO MANAGE FOOD PAGE
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>
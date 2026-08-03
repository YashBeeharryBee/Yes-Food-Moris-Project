<?php

// INCLUDE CONSTANTS.PHP FILE FOR SITEURL
include('../config/constants.php');

// CHECK WHETHER ID AND IMAGE_NAME VALUE IS SET OR NOT
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // GET THE VALUE AND DELETE
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // REMOVE THE IMAGE IF AVAILABLE
    if($image_name!="")
    {
        // IMAGE IS AVAILABLE. SO, REMOVE IT
        $path = "../images/category/".$image_name;

        // REMOVE THE IMAGE
        $remove = unlink($path);

        // CHECK WHETHER THE IMAGE IS REMOVED OR NOT
        if($remove==false)
        {
            // FAILED TO REMOVE IMAGE
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
            // REDIRECT TO MANAGE CATEGORY PAGE
            header('location:'.SITEURL.'admin/manage-category.php');
            // STOP THE PROCESS
            die();
        }
    }

    // DELETE DATA FROM DATABASE
    // SQL QUERY TO DELETE DATA FROM DATABASE
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    // EXECUTE THE QUERY
    $res = mysqli_query($conn, $sql);

    //CHECK WHETHER THE DATA IS DELETED FROM DATABASE OR NOT
    if($res==true)
    {
        // SET SUCCESS MESSAGE AND REDIRECT
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div>";
        // REDIRECT TO MANAGE CATEGORY PAGE
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        // SET FAIL MESSAGE AND REDIRECT
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
        // REDIRECT TO MANAGE CATEGORY PAGE
        header('location:'.SITEURL.'admin/manage-category.php');
    }


    // REDIRECT TO MANAGE CATEGORY WITH MESSAGE
}
else
{
    // REDIRECT TO MANAGE CATEGORY PAGE
    header('location:'.SITEURL.'admin/manage-category.php');
}

?>

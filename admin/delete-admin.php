<?php

    // INCLUDE CONSTANTS.PHP FILE FOR SITEURL
    include('../config/constants.php');


    // GET THE ID OF ADMIN TO BE DELETED
    $id = $_GET['id'];

    // CREATE SQL QUERY TO DELETE ADMIN
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    // EXECUTE THE QUERY
    $res = mysqli_query($conn, $sql);

    // CHECK WHETHER THE QUERY EXECUTED SUCCESSFULLY OR NOT
    if($res==true)
    {
        // QUERY EXECUTED SUCCESSFULLY AND ADMIN DELETED
        // CREATE SESSION VARIABLE TO DISPLAY MESSAGE
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        // REDIRECT TO MANAGE ADMIN PAGE
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else
    {
        // FAILED TO DELETE ADMIN
        // CREATE SESSION VARIABLE TO DISPLAY MESSAGE
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again.</div>";
        // REDIRECT TO MANAGE ADMIN PAGE
        header("location:".SITEURL.'admin/manage-admin.php');
    }

    // REDIRECT TO MANAGE ADMIN PAGE WITH MESSAGE (SUCCESS/ERROR)
    
?>
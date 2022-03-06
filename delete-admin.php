<?php

    // include contants.php file here
    include('../config/constants.php');

    //get the id of admin to delete it
    $id = $_GET['id'];

    //create sql query to delete admin
    $sql = "DELETE FROM admin WHERE id= $id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check whether the query executed successfully or not
    if($res == TRUE){
        //query executed successfully and admin deleted
        //echo "Admin Deleted!";
        //create a session
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully!.</div></br></br>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //echo "Failed! Try again..";
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again!.</div></br></br>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    
    //redirect to manage admin page with message

?>
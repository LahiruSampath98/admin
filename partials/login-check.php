<?php
    //Authorization - access control
    //check whether the user is logged in or not

    if(!isset($_SESSION['user'])){
        $_SESSION['no-login-message'] = "<div class='error text-center'> Please Login to access admin panel.</div></br></br>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>
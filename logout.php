<?php
    include('../config/constants.php');
    // Destroy the session
    session_destroy(); //unset $_session['user'] 

    // redirect ot login page
    header('location:'.SITEURL.'admin/login.php');

?>
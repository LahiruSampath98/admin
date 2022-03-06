<?php 
    //inclue constant page
    include('../config/constants.php');

    //check whether value is passed
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //process to delete
        //get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the image if available
        if($image_name!="")
        {
            //if has image and need to remove from folder
            //get the image path
            $path = "../images/food/".$image_name;

            //remove image file from folder
            $remove = unlink($path);

            // check whether is image is removed or not
            if($remove==false)
            {
                //failed to remove
                $_SESSION['upload'] = "<div class='error'>Failed To Remove Image.</div></br></br>";
                header('location:'.SITEURL.'admin/manage-food.php');
                die();
            }
        }

        //delete from database
        $sql = "DELETE FROM food_items WHERE id=$id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check whethtr the query exetued or not
        if($res==true)
        {
            //food dleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div></br></br>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //failed to delete food
            $_SESSION['delete'] = "<div class='error'>Failed To Delete Food.</div></br></br>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }

        //redirect to manage food with session message
    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access.</div></br></br>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }



?>
<?php 
    //include constant file
    include('../config/constants.php');
    //check whether the id and image_name is set or not 
if(isset($_GET['id']) and isset($_GET['image_name'])){
    //get the vlaue and delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //remove the physical image file
    if($image_name!="")
    {
        //image is available.so remove it
        $path = "../images/category/".$image_name;
        //remove the image
        $remove = unlink($path);

        //
        if($remove == false){
            //set the session message
            $_SESSION['remove'] = "<div class='error'>Failed to remove Category Image.</div></br></br>";
            //redirect ot manage-category page
            header('location:'.SITEURL.'admin/manage-category.php');
            //stop the process
            die();
        }
    }
    //delete data from database
    //sql query to delete data from database
    $sql = "DELETE FROM food_category WHERE id=$id";

    //execute the query
    $res = mysqli_query($conn, $sql);

    //check data deleted from database or not
    if($res==true){
        //set success message
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully.</div></br></br>";
        //redirect ot manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        //set success message
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div></br></br>";
        //redirect ot manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }

    //redirct to manage-category page with message

}
else
{
    //redirect to manage category page
    header('location:'.SITEURL.'admin/manage-category.php');
}




?>
<?php include('partials/menu.php'); ?>

<div class="content">
    <div class="wrapper">
        <h1>Add Category</h1>
</br></br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <!-- Add category form starts -->
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-admin">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="yes"> Yes
                        <input type="radio" name="featured" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="yes">Yes
                        <input type="radio" name="active" value="no"> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-update">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add category form ends -->

        <?php

            if(isset($_POST['submit'])){
                //get the value from form
                $title = $_POST['title'];

                //for radio imput, we need to check wheather the button is selected is not
                if(isset($_POST['featured'])){
                    //get the value from the form
                    $featured = $_POST['featured'];

                }
                else{
                    //set the value
                    $featured = "No";
                }
                
                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //check whether the image is selected or not and set the value for image name
                //print_r($_FILES['image']);
                //die();

                if(isset($_FILES['image']['name'])){
                    //upload the image
                    //To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //upload image only if image is selected
                    if($image_name!="")
                    {
                        //Auto rename the image
                        //Get the extension of out image(jpg,png, gif,etc)
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //ex: Food_Category_332.jpg

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        $upload = move_uploaded_file($source_path, $destination_path);

                        //check whether the image is uploaded or not
                        //and if image not uploaded redirect with error message
                        if($upload==false){
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div></br></br>";
                            //redirect
                            header('location:'.SITEURL.'admin/add-category.php');
                            die();
                        }
                    }
                }
                else
                {
                    //dont upload image and set the image_name value as blank
                    $image_name = "";
                }

                //create sql query to insert category into database
                $sql = "INSERT INTO food_category SET
                    title='$title',
                    image_name = '$image_name',
                    featured='$featured',
                    active ='$active'
                    ";

                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    //check whether the query executed or not
                    if($res==true){
                        //query executed and category added
                        $_SESSION['add'] = "<div class='success'> Category Added Successfully.</div></br></br>";
                        //redirect
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else{
                        //failed to add category
                        $_SESSION['add'] = "<div class='success'> Failed to add category.</div></br></br>";
                        //redirect
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }


            }


        ?>

    </div>
</div>





<?php include('partials/footer.php'); ?>
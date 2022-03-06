<?php include('partials/menu.php') ?>

<div class="content">
    <div class="wrapper">
        <h1>Update Category</h1>
</br></br>

        <?php
            //check whether the id is set or not
            if(isset($_GET['id'])){
                //get the id and all other informations
                $id = $_GET['id'];
                
                //crate sql query to get all other details
                $sql = "SELECT * FROM food_category WHERE id=$id";

                //execute the query
                $res = mysqli_query($conn, $sql);

                //count the rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);

                if($count==1){
                    //get all the data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else 
                {
                    //redirect to manage category with session message
                    $_SESSION['no-category'] = "<div class='error'>Category Not Found.</div></br></br>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
            else
            {
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>

        <form action="" method="post" enctype="mulipart/form-data">
            <table class="tbl-admin">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image!="")
                            {
                                //display the image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="100px">
                                <?php
                            }
                            else
                            {
                                //display the image
                                echo "<div class='error'>No Image Uploaded.</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="yes"){echo "checked";} ?> type="radio" name="featured" value="yes">Yes
                        <input <?php if($featured=="no"){echo "checked";} ?> type="radio" name="featured" value="no">No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="yes"){echo "checked";} ?> type="radio" name="active" value="yes">Yes
                        <input <?php if($active=="no"){echo "checked";} ?> type="radio" name="active" value="no">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-update">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit'])){
                //get all the values from our form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                

                //updating new image if selected
                //check whether image is selected or not
                if(isset($_FILES['image']['name']))
                {
                    //get the image details
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is available or not
                    if($image_name !="")
                    {
                        //Image available
                        //upload the new image

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
                            header('location:'.SITEURL.'admin/manage-category.php');
                            die();
                        }

                        //remove the current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            //check whether the image is removed or not
                            //if failed to remove then display the message and stop the processes
                            if($remove==false){
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image.</div></br></br>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();//stop the process
                            }
                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                //update the database
                $sql2 = "UPDATE food_category SET
                    title='$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";
                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                //redirect ot manage category with message
                //check whether executed or not
                if($res2 == true){
                    //category updated
                    $_SESSION['update'] = "<div calss='success'>Category Updated Successfully.</div></br></br>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div calss='success'>Failed to Update Category.</div></br></br>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }


        ?>
    </div>
</div>




<?php include('partials/footer.php') ?>
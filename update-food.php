<?php include('partials/menu.php'); ?>

<?php
    //check whether id is set or not
    if(isset($_GET['id'])){
        //get all the details
        $id = $_GET['id'];

        //sql query to get the selectd food
        $sql2 = "SELECT * FROM food_items WHERE id=$id";

        //execute the query
        $res2 = mysqli_query($conn, $sql2);

        //get the value based on query executed
        $row = mysqli_fetch_assoc($res2);

        //get the individual value of selected food
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $current_category = $row['category_id'];
        $featured =$row['featured'];
        $active = $row['active'];


    }
    else
    {
        //redirect to the manage food
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>

    <div class="content">
        <div class="wrapper">
            <h1>Update Food</h1>

</br></br>

            <form action="" method="post" ecntype="mulipart/form-data">
                <table class="tbl-admin">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" id="" cols="30" rows="5"><?php echo $description; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" value="<?php echo $price; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Image: </td>
                        <td>
                            <?php
                                if($current_image=="")
                                {
                                    //image not available
                                    echo "<div class='error'>Image Not Abalaible.</div>";
                                }
                                else
                                {
                                    //image available
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="<?php echo $title; ?>" width="100px">
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Select New Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category" id="">
                                <?php
                                    //query to get active categories
                                    $sql = "SELECT * FROM food_category WHERE active='yes'";

                                    //execute the query
                                    $res = mysqli_query($conn, $sql);

                                    //count rows
                                    $count = mysqli_num_rows($res);

                                    //category available or not
                                    if($count > 0)
                                    {
                                        //category availabe
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            $category_title = $row['title'];
                                            $category_id = $row['id'];

                                            ?>
                                            <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        //category not available
                                        echo "<option value='0'>Category Not Availabe.</option>";
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured=="yes"){echo "checked";} ?> type="radio" name="featured" value="yes">yes
                            <input <?php if($featured=="no"){echo "checked";} ?> type="radio" name="featured" value="no">No
                        </td>
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active=="yes"){echo "checked";} ?> type="radio" name="active" value="yes">yes
                            <input <?php if($active=="no"){echo "checked";} ?> type="radio" name="active" value="no">No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="submit" name="submit" value="Update Food" class="btn-update">
                        </td>
                    </tr>
                </table>
            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    //get all the details from the form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image =$_POST['current_image'];
                    $category = $_POST['category'];

                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    //upload the image selected

                    //check whether upload button is clecked or not
                    if(isset($_FILES['image']['name']))
                    {
                        //upload button clicked
                        $image_name = $_FILES['image']['name'];//new image;s name

                        //ckeck whether the file is availabe or not
                        if($image_name!="")
                        {
                            //image is available
                            //uploading the new image

                            //rename the image name
                            $ext = end(explode('.',$image_name));
                            $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //new name of the new image

                            //ge the destination path
                            $src_path = $_FILES['image']['tmp_name'];//source path
                            $dest_path = "../images/food/".$image_name;//destination path

                            //upload the image
                            $upload = move_uploaded_file($src_path, $dest_path);

                            //check whether the image is uploaded or not
                            if($upload == false)
                            {
                                //failed to upload
                                $_SESSION['update'] = "<div class='error'>Failed To Upload The Image.</div></br></br>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }

                            // remove the current image if available
                            if($current_image!="")
                            {
                                //cureent image is available
                                //remove the image if uploaded
                                $remove_path = "../images/food/".$current_image;
                                $remove = unlink($remove_path);

                                //check whether image is removed or not
                                if($remove == false)
                                {
                                    //failed to remove current image
                                    $_SESSION['remove'] = "<div class='error'>Failed To Remove The Current Image.</div></br></br>";
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    die();
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

                    //update the food in database 
                    $sql3 = "UPDATE food_items SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id=$id 
                    ";

                    //execute the query
                    $res3 = mysqli_query($conn, $sql3);

                    //check whether the query is executed or not
                    
                    if($res3==true){
                        //query executed and food updated
                        $_SESSION['update_image'] = "<div class='success'>Food Updated Successfully.</div></br></br>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        //failed to update
                        $_SESSION['update_image'] = "<div class='error'>Failded To Update The Food.</div></br></br>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }

                    //redirect to manage food with session message 
                }
            ?>
        </div>
    </div>



<?php include('partials/footer.php'); ?>
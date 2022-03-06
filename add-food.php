<?php include('partials/menu.php'); ?>

<div class="content">
    <div class="wrapper">
        <h1>Add Food</h1>

</br></br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-admin">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" >
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                        <?php
                            //create php code to display categories from database
                            //create sql to get all active categories
                            $sql = "SELECT * FROM food_category WHERE active='yes'";

                            //executing the query
                            $res = mysqli_query($conn, $sql);

                            //count the rows to check whether the we have categories or not
                            $count = mysqli_num_rows($res);

                            //if count is zero, we have categories else we do not have categories
                            if($count > 0)
                            {
                                //we have categories
                                while($row=mysqli_fetch_assoc($res)){
                                    //get the details of categories
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>

                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //we do not have categories
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }

                            //display on dropdown
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="yes">Yes
                        <input type="radio" name="featured" value="no">NO
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="yes">Yes
                        <input type="radio" name="active" value="no">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-add">
                    </td>
                </tr>
            </table>

        </form>

        <?php
            //check whether the button clicked or not
            if(isset($_POST['submit'])){
                //add the food in database
                //get the data from form 
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check whether radio buttonn active or not
                if(isset($_POST['featured'])){
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No";//setting the default value
                }
                if(isset($_POST['active'])){
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";//setting default value
                }

                //upload the image if selected
                //check whether the select image is clicked or not and updload the image if the image is selected
                if(isset($_FILES['image']['name'])){
                    //get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is selected or not and upload image only if slected
                    if($image_name!=""){
                        //image is selected
                        //rename the image 
                        //get the extension selected(lpg, png, jpeg, etc.)
                        $ext = end(explode('.', $image_name));

                        //create new name for image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; //new image name

                        //upload the image
                        //get the source path and destination path

                        //source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        //Destination path for the image to be uploaded
                        $dst = "../images/food/".$image_name;

                        //finaly upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        //check whether image uploaded or not
                        if($upload == false)
                        {
                            //failed to upload the image
                            //redirect to add food page with message
                            $_SESSION['upload'] = "<div class='error'>Failed To Upload The Image.</div></br></br>";
                                header('location:'.SITEURL.'admin/add-food.php');
                            //stop the process
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = ""; //selected defalut value as blank
                }

                //insert into dataase
                //create a sql query to add food 
                //for numerical we do not need to pass value inside quoed '' but for string value it is compulsory to add quotes ''
                $sql2 = "INSERT INTO food_items SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";
                //execute the query
                $res2 = mysqli_query($conn, $sql2);

                if($res2 == true){
                    //data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div></br></br>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed To Add Food.</div></br></br>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                //redirect with message to manage food page
            }
        ?>
    </div>
</div>



<?php include('partials/footer.php'); ?>
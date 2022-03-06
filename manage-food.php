<?php include('partials/menu.php'); ?>

    <div class="content">
        <div class="wrapper"> 
            <h1>Manage Foods</h1>

            <div class="clearfix"></div>

            </br></br>
                <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-add"> Add Food </a>
            </br></br>

            <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                if(isset($_SESSION['upload'])){
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
                if(isset($_SESSION['unauthorized'])){
                    echo $_SESSION['unauthorized'];
                    unset($_SESSION['unauthorized']);
                }
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                if(isset($_SESSION['remove'])){
                    echo $_SESSION['remove'];
                    unset($_SESSION['remove']);
                }
                if(isset($_SESSION['update_image'])){
                    echo $_SESSION['update_image'];
                    unset($_SESSION['update_image']);
                }
            ?>

            <table class="tbl-admin">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>

                <?php
                    $sn = 1;
                    //create a sql query to get all the food
                    $sql = "SELECT * FROM food_items";

                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    //count the rows to check whether we have foods or not
                    $count = mysqli_num_rows($res);

                    if($count>0){
                        //we have food in database
                        //get the foods from database and display
                        while($row=mysqli_fetch_assoc($res)){
                            //get the value from individual columns
                            $id = $row['id'];
                            $title = $row['title'];
                            $price = $row['price'];
                            $image_name = $row['image_name'];
                            $featured = $row['featured'];
                            $active = $row['active'];
                            ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo $title; ?></td>
                                <td>Rs.<?php echo $price; ?></td>
                                <td>
                                    <?php
                                        //check whether we have image or not
                                        if($image_name=="")
                                        {
                                            //we do not have image, display error message
                                            echo "<div class='error'> No Image Uploaded.</div>";
                                        }
                                        else
                                        {
                                            //we have the image
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>

                                <td> <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-update">Update Food</a> 
                                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-delete">Delete Food</a></td>
                            </tr>
                            <?php
                        }
                    }
                    else
                    {
                        //food not added to database
                        echo "<tr><td colspan='7' class='error'>Foods Not Added Yet.</td></tr>";
                    }
                ?>

                


            </table>

        </div>
    </div>



    <?php include('partials/footer.php'); ?>
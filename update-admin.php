<?php include('partials/menu.php'); ?>

    <div class="content">
        <div class="wrapper">
        <h1>Update Admin</h1>

</br></br>

        <?php
            //get the id of the admin
            $id = $_GET['id'];
            
            //udpate sql query
            $sql = "SELECT * FROM admin WHERE id=$id";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            //check whether the query is executed or not
            if($res==TRUE){
                //check the data is available or not
                $count = mysqli_num_rows($res);

                //check we have admin data or not
                if($count==1){
                    //get the details
                    $row = mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];

                }
                else{
                    //redirect to manage page
                    header('location'.SITEURL.'admin/manage-admin.php');
                }
            }

        ?>
        <form action="" method="post">
        <table class="tbl-admin">
                <tr>
                    <td>
                        Full name: 
                    </td>
                    <td>
                        <input type="text" name="fname" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Username: 
                    </td>
                    <td>
                        <input type="text" name="uname" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input  type="hidden" name="id" value="<?php echo $id; ?>">
                        <input  type="submit" name="submit" value="Update admin" class="btn-update">
                    </td>
                </tr>
            </table>
        </form>
        </div>
    </div>


<?php

            //check whether submit button is clicked or not
            if(isset($_POST['submit'])){
                //echo "Button clicked";
                //het all the values from the form to update
                $id = $_POST['id'];
                $full_name = $_POST['fname'];
                $username = $_POST['uname'];

                //create a sql query to update admin
                $sql = "UPDATE admin SET
                    full_name = '$full_name',
                    username = '$username' 
                    WHERE id= '$id'
                ";

                //execute the query
                $res= mysqli_query($conn, $sql);

                if($res==TRUE){
                    //Query executed and admin updated
                    $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div></br></br>";
                    header("location: ".SITEURL.'admin/manage-admin.php');
                }
                else
                {
                    //Failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to Update Admin.. Try Again!!.</div></br></br>";
                    header("location: ".SITEURL.'admin/manage-admin.php');
                }
            }


?>

<?php include('partials/footer.php'); ?>
<?php include('partials/menu.php'); ?>

    <div class="content">
        <div class="wrapper">
            <h1>Change Password</h1>
</br></br>
            <?php
                if(isset($_GET['id'])){
                    $id = $_GET['id'];
                }

            ?>
            <form action="" method="POST">
                <table class="tbl-admin">
                    <tr>
                        <td>
                            Old Password:
                        </td>
                        <td>
                            <input type="password" name="old_password" placeholder="Old Password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            New Password:
                        </td>
                        <td>
                            <input type="password" name="new_password" placeholder="New Password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Confirm Password:
                        </td>
                        <td>
                            <input type="password" name="confirm_password" placeholder="Confirm Password">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input  type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Change Password" class="btn-update">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php
        //check whether the submit button is clicked or not
        if(isset($_POST['submit'])){
            //get the data from form
            $id = $_POST['id'];
            $current_password = md5($_POST['old_password']);
            $new_passwrod = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);

            // check whether the user with current id and current password exists or not
            $sql = "SELECT * FROM admin WHERE id=$id AND password='$current_password'";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            if($res == TRUE){
                $count = mysqli_num_rows($res);

                if($count==1){
                    //user exits and password can be change
                    if($new_passwrod == $confirm_password){
                        //Update the password
                        $sql2 = "UPDATE admin SET password='$new_passwrod' WHERE id= $id";

                        $res2 = mysqli_query($conn, $sql2);

                        if($res2 == TRUE){
                            //Display success message
                            $_SESSION['change-pwd'] = "<div class='success'>Password Change Successfully..</div></br></br>";
                            header("location: ".SITEURL.'admin/manage-admin.php');
                        }
                        else
                        {
                            //Display error message
                            $_SESSION['change-error-pwd'] = "<div class='success'>Faild To Change The Password. Try Again!</div></br></br>";
                            header("location: ".SITEURL.'admin/manage-admin.php');
                        }
                    }
                    else
                    {
                        //redirect to manage page
                        $_SESSION['pwd-not-found'] = "<div class='error'>Password Not Match.</div></br></br>";

                        //Redirect to the manage page
                        header("location: ".SITEURL.'admin/manage-admin.php');
                    }
                }
                else{
                    $_SESSION['user-not-found'] = "<div class='error'>User not Found.</div></br></br>";

                    //Redirect to the manage page
                    header("location: ".SITEURL.'admin/manage-admin.php');
                }
            }

            //check whether the new password and confirm password match


            //change password if all above is true
        }
    ?>




<?php include('partials/footer.php'); ?>
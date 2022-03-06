<?php include('partials/menu.php'); ?>

<div class="content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        </br></br>

        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']); //Removing session message
            }

        ?>
        <form action="" method="post">
            <table class="tbl-admin">
                <tr>
                    <td>
                        Full name: 
                    </td>
                    <td>
                        <input type="text" name="fname" placeholder="Enter your full name">
                    </td>
                </tr>
                <tr>
                    <td>
                        Username: 
                    </td>
                    <td>
                        <input type="text" name="uname" placeholder="Enter Username">
                    </td>
                </tr>
                <tr>
                    <td>
                        Password: 
                    </td>
                    <td>
                        <input type="password" name="pass" placeholder="Enter Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input  type="submit" name="submit" value="Add admin" class="btn-update">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>


<?php include('partials/footer.php'); ?>

<?php
    //save data in database
    //check whether the button is clicked or not
    if(isset($_POST['submit'])){
        $fname = $_POST['fname'];
        $uname = $_POST['uname'];
        $pass = md5($_POST['pass']);

        $sql = "INSERT INTO admin SET
            full_name = '$fname',
            username = '$uname',
            password = '$pass'
        ";

        
        //$db_select = mysqli_connect($conn, ) or die(mysqli_error());

        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        if($res == TRUE){
            $_SESSION['add'] = "<div class='success'>Admin added succesfully!.</div></br></br>";
            header("location: ".SITEURL.'admin/manage-admin.php');
        }
        else{
            $_SESSION['add'] = "<div class='error'>Failed to add admin!.</div></br></br>";
            header("location: ".SITEURL.'admin/add-admin.php');
        }

        


    }


?>
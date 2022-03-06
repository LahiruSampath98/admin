<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login">
            <h1 class="text-center">Login</h1></br>

            <?php 
                
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message'])){
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            
            ?>

            <!-- Login form starts here -->
            <form action="" method="post" class="text-center">
                <h4>Username:</h4>
                <input type="text" name="username" placeholder="Enter Username"></br></br>
                <h4>Password:</h4>
                <input type="password" name="password" placeholder="Enter Password"></br></br>
                <input type="submit" name="submit" value="Login" class="btn-add">
            </form>
            
        </div>
    </body>
</html>


<?php
    //check whether the submit button is clicked or not

    if(isset($_POST['submit'])){
        //get the data from form

        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //check whether username and password exist or not

        $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";

        //Execute the query

        $res = mysqli_query($conn, $sql);

        //count rows to check whether username and password exist or not

        $count = mysqli_num_rows($res);

        if($count==1){
            //user available
            $_SESSION['login'] = "<div class='success'>Login Successfull.</div></br></br>";
            $_SESSION['user'] = $username; //check to user log in or not


            //redirect to home page
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //user not available and login fail
            $_SESSION['login'] = "<div class='error'>Login Failed.</div></br></br>";
            //redirect to home page
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>
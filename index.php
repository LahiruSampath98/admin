<?php include('partials/menu.php'); ?>


    <div class="content">
        <div class="wrapper"> 
            <h1>DASHBOARD</h1></br></br>

            <?php 
                
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
            
            ?>

            <div class="col text-center">
                <h1>5</h1></br>
                <b>Categories</b>
            </div>

            <div class="col text-center">
                <h1>5</h1></br>
                <b>Categories</b>
            </div>

            <div class="col text-center">
                <h1>5</h1></br>
                <b>Categories</b>
            </div>

            <div class="col text-center">
                <h1>5</h1></br>
                <b>Categories</b>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>



    <?php include('partials/footer.php'); ?>
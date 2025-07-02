<?php include("partials/menu.php"); ?>

<!-- Main section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>DASHBOARD</h1>
        <br><br>

        <?php 
        if (isset($_SESSION['login'])) {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }
        ?>
        <br><br>

        <div class="col-4 text-center">
            <?php 
            $sql = "SELECT * FROM tbl_category";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            ?>
            <h1><?php echo $count; ?></h1>
            <br />
            Categories
        </div>

        <div class="col-4 text-center">
            <?php 
            $sql1 = "SELECT * FROM tbl_food";
            $res1 = mysqli_query($conn, $sql1);
            $count1 = mysqli_num_rows($res1);
            ?>
            <h1><?php echo $count1; ?></h1>
            <br />
            Foods
        </div>

        <div class="col-4 text-center">
            <?php 
            $sql2 = "SELECT * FROM tbl_order";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);
            ?>
            <h1><?php echo $count2; ?></h1>
            <br />
            Total Orders
        </div>

        <div class="col-4 text-center">
            <?php
            $sql3 = "SELECT SUM(total) AS total FROM tbl_order WHERE state='delivered'";
            $res3 = mysqli_query($conn, $sql3);
            $row3 = mysqli_fetch_assoc($res3);
            $total_revenues = $row3["total"] ?? 0; // In case it's NULL
            ?>
            <h1>Rs. <?php echo $total_revenues; ?></h1>
            <br />
            Revenue Generated
        </div>

        <div class="clearfix"></div>
    </div>
</div>
<!-- Main section ends -->

<?php include("partials/footer.php"); ?>

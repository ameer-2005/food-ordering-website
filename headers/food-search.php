<?php include('partials-front/menu.php'); ?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <?php
        $search=$_POST['search'];
        
        // Check if form was submitted
        if (isset($_POST['search'])) {
            // Connect to DB if not included in menu.php
            $search = mysqli_real_escape_string($conn, $_POST['search']);
        } else {
            $search = '';
        }
        ?>
        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>
    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<!-- FOOD Menu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
        $res = mysqli_query($conn, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php if ($row['image_name'] != "") { ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $row['image_name']; ?>" class="img-responsive img-curve">
                        <?php } else {
                            echo "<div class='error'>Image not available.</div>";
                        } ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $row['title']; ?></h4>
                        <p class="food-price">$<?php echo $row['price']; ?></p>
                        <p class="food-detail"><?php echo $row['description']; ?></p>
                        <br>
                        <a href="#" class="btn btn-primary">Order Now</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
            }
        } else {
            echo "<div class='error text-center'>No foods found for \"$search\".</div>";
        }
        ?>
    </div>
</section>
<!-- FOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

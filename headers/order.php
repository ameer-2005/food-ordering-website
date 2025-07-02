<?php 
include('partials-front/menu.php'); 



// Check whether food ID is set
if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    // Use prepared statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM tbl_food WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $food_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = htmlspecialchars($row['title']);
        $price = $row['price'];
        $image_name = htmlspecialchars($row['image_name']);
    } else {
        // If the food item is not found
        header("Location: " . SITEURL);
        exit();
    }
} else {
    // If food ID is not set
    header("Location: " . SITEURL);
    exit();
}
?>

<!-- Food Search Section Starts Here -->
<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    if ($image_name == "") {
                        echo "<div class='error'>Image not found</div>";
                    } else {
                        ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" 
                             alt="<?php echo $title; ?>" 
                             class="img-responsive img-curve">
                        <?php
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>

                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. ameerunnisa" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. amee@gmail.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>
        </form>

        <?php 
        if (isset($_POST['submit'])) {
            // Get order details
            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $order_date = date('Y-m-d H:i:s');
            $state = 'ordered'; // Fixed the typo from $status to $state
            $customer_name = $_POST['full-name'];
            $customer_email = $_POST['email'];
            $customer_contact = $_POST['contact'];
            $customer_address = $_POST['address'];

            // Prepare the SQL query using placeholders
            $sql2 = "INSERT INTO tbl_order (food, price, qty, total, order_date, state, customer_name, customer_email, customer_contact, customer_address)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Use prepared statement to avoid SQL injection
            $stmt2 = mysqli_prepare($conn, $sql2);

            if ($stmt2 === false) {
                // Check if the statement preparation failed
                die("Error preparing the SQL query: " . mysqli_error($conn));
            }

            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt2, 'sdiiisssss', $food, $price, $qty, $total, $order_date, $state, $customer_name, $customer_email, $customer_contact, $customer_address);

            // Execute the query
            $res2 = mysqli_stmt_execute($stmt2);

            // Check if the query was successful
            if ($res2 == TRUE) {
                $_SESSION['order'] = "<div class='success text-center' >Food ordered successfully.</div>";
                header("Location: " . SITEURL); // Redirect to the home page with the success message
                exit();
            } else {
                $_SESSION['order'] = "<div class='error'>Failed to order food. Error: " . mysqli_error($conn) . "</div>";
                header("Location: " . SITEURL); // Redirect to the home page with the error message
                exit();
            }
        }
        ?>
    </div>
</section>
<!-- Food Search Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

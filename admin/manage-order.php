<?php include("partials/menu.php"); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <link rel="stylesheet" href="../css/admin.css">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br><br>

        <?php 
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
            echo "<br><br>";
        }
        ?>

        <table class="tbl-full">
            <tr> 
                <th>S.N</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>State</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>

            <?php 
            $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            $sn = 1;

            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $id = $row["id"];
                    $food = $row["food"];
                    $price = $row["price"];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_Date = $row['order_Date']; // fixed case from order_Date
                    $state = $row['state'];
                    $customer_name = $row['customer_name'];
                    $customer_address = $row['customer_address'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $food; ?></td>
                        <td>$<?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td>$<?php echo $total; ?></td>
                        <td><?php echo $order_Date; ?></td>
                        <td><?php echo $state; ?></td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td>
                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                        </td>
                    </tr>

                    <?php 
                }
            } else {
                echo "<tr><td colspan='12' class='error'>Orders not available</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include("partials/footer.php"); ?>

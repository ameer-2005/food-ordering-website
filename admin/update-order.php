<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <?php 
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM tbl_order WHERE id = $id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);

            if ($count == 1) {
                $row = mysqli_fetch_assoc($res);

                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $state = $row['state'];
                $customer_name = $row['customer_name'];
                $customer_address = $row['customer_address'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
            } else {
                header('location:' . SITEURL . 'admin/manage-order.php');
                exit;
            }
        } else {
            header('location:' . SITEURL . 'admin/manage-order.php');
            exit;
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td><b>$<?php echo $price; ?></b></td>
                </tr>

                <tr>
                    <td>Qty</td>
                    <td><input type="number" name="qty" value="<?php echo $qty; ?>" required></td>
                </tr>

                <tr>
                    <td>State</td>
                    <td>
                        <select name="state">
                            <option value="ordered" <?php if ($state == "ordered") echo "selected"; ?>>Ordered</option>
                            <option value="on-delivery" <?php if ($state == "on-delivery") echo "selected"; ?>>On Delivery</option>
                            <option value="delivered" <?php if ($state == "delivered") echo "selected"; ?>>Delivered</option>
                            <option value="cancelled" <?php if ($state == "cancelled") echo "selected"; ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Address</td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5" required><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td>Customer Email</td>
                    <td>
                        <input type="email" name="customer_email" value="<?php echo $customer_email; ?>" required>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $state = $_POST['state'];
            $customer_name = $_POST['customer_name'];
            $customer_address = $_POST['customer_address'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];

            $sql2 = "UPDATE tbl_order SET
                        qty = $qty,
                        total = $total,
                        state = '$state',
                        customer_name = '$customer_name',
                        customer_address = '$customer_address',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email'
                    WHERE id = $id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION["update"] = "<div class='success'>Order updated successfully.</div>";
            } else {
                $_SESSION["update"] = "<div class='error'>Order not updated successfully.</div>";
            }

            header("location:" . SITEURL . "admin/manage-order.php");
            exit;
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

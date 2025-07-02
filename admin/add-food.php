<?php 
include('partials/menu.php'); 

if (!isset($conn)) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
        if (isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Title of the Food" required></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td><textarea name="description" cols="30" rows="5" placeholder="Description of the Food." required></textarea></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" required></td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image" required></td>
                </tr>

                <!-- Category removed -->

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No" checked> No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No" checked> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);
            $featured = isset($_POST['featured']) ? mysqli_real_escape_string($conn, $_POST['featured']) : "No";
            $active = isset($_POST['active']) ? mysqli_real_escape_string($conn, $_POST['active']) : "No";

            // Default category or NULL (depends on your DB design)
            $category = 0;

            $image_name = "";

            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];
                $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;

                $src = $_FILES['image']['tmp_name'];
                $dst = "../images/food/" . $image_name;

                $upload = move_uploaded_file($src, $dst);

                if ($upload == false) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                    header("Location: " . SITEURL . "admin/add-food.php");
                    exit();
                }
            }

            $sql2 = "INSERT INTO tbl_food (title, description, price, image_name, category_id, featured, active) 
                     VALUES ('$title', '$description', '$price', '$image_name', '$category', '$featured', '$active')";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == TRUE) {
                $_SESSION["add"] = "<div class='success'>Food added successfully.</div>";
                header("Location: " . SITEURL . "admin/manage-food.php");
                exit();
            } else {
                $_SESSION["add"] = "<div class='error'>Food not added. Error: " . mysqli_error($conn) . "</div>";
                header("Location: " . SITEURL . "admin/manage-food.php");
                exit();
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>

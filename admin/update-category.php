<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>

        <?php 
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_category WHERE id=$id";

                $res = mysqli_query($conn, $sql);

                if ($res == true) {
                    $count = mysqli_num_rows($res);
                    if ($count == 1) {
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                    } else {
                        $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                        header("Location: " . SITEURL . "admin/manage-category.php");
                        exit;
                    }
                }
            } else {
                header("Location: " . SITEURL . "admin/manage-category.php");
                exit;
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php 
                            if ($current_image != "") {
                                echo "<img src='" . SITEURL . "images/category/$current_image' width='100px'>";
                            } else {
                                echo "<div class='error'>Image not added.</div>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if($featured == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if($featured == "No") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if($active == "Yes") echo "checked"; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if($active == "No") echo "checked"; ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        // Process form submission
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Check if new image is selected
            if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                $image_name = $_FILES['image']['name'];
                $ext = end(explode('.', $image_name));
                $image_name = "Food_Category_" . rand(000, 999) . "." . $ext;

                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/" . $image_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if ($upload == false) {
                    $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                    header("Location: " . SITEURL . "admin/manage-category.php");
                    exit;
                }

                if ($current_image != "") {
                    $remove_path = "../images/category/" . $current_image;
                    $remove = unlink($remove_path);
                }
            } else {
                $image_name = $current_image;
            }

            // Update the database
            $sql2 = "UPDATE tbl_category SET 
                title = '$title', 
                image_name = '$image_name', 
                featured = '$featured', 
                active = '$active' 
                WHERE id = $id";

            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION['update'] = "<div class='success'>Category updated successfully.</div>";
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to update category.</div>";
            }

            header("Location: " . SITEURL . "admin/manage-category.php");
            exit;
        }
        ?>
    </div>
</div>

<?php include("partials/footer.php"); ?>

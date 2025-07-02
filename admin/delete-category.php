<?php
include('../config/constants.php');


if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Debugging: Log received parameters
    error_log("Delete Request - ID: $id, Image Name: $image_name");

    // Remove the physical image file if it exists
    if ($image_name != "") {
        $path = "../images/category/" . $image_name;
        if (file_exists($path)) {
            $remove = unlink($path);
            if ($remove == false) {
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
                header("Location: " . SITEURL . "admin/manage-category.php");
                exit();
            }
        } else {
            // Debugging: Log if file does not exist
            error_log("File not found: $path");
        }
    }

    // Delete data from Database
    $sql = "DELETE FROM tbl_category WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'>Category deleted successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete category from database.</div>";
        // Debugging: Log MySQL error
        error_log("MySQL Error: " . mysqli_error($conn));
    }

    header("Location: " . SITEURL . "admin/manage-category.php");
    exit();

} else {
    $_SESSION['delete'] = "<div class='error'>Unauthorized access.</div>";
    header("Location: " . SITEURL . "admin/manage-category.php");
    exit();
}
?>

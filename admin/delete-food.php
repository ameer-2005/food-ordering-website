<?php 
include("../config/constants.php"); // Include database connection

// Start session to use session variables
session_start();

// Check if the ID and image name are set in the URL
if (isset($_GET['id']) && isset($_GET['image_name'])) {
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // Remove the image file if it exists
    if ($image_name != "") {
        $path = "../images/food/" . $image_name;

        // Attempt to delete the image file
        $remove = unlink($path);
        if ($remove == false) {
            $_SESSION['delete'] = "<div class='error'>Failed to remove image file.</div>";
            header("location:" . SITEURL . "admin/manage-food.php");
            die();
        }
    }

    // Delete the food item from the database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    // Check if the deletion was successful
        // Check if the deletion was successful
        if ($res == true) {
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
        } else {
            $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
        }
    
        // Redirect to the manage food page
        header("location:" . SITEURL . "admin/manage-food.php");
    } else {
        // Redirect to manage food page if ID or image name is not set
        header("location:" . SITEURL . "admin/manage-food.php");
    }
    ?>
<?php include("partials/menu.php"); ?>

<div class="main-content">
  <h1>Add Category</h1>
  <br>

  <?php 
    if(isset($_SESSION['add'])) {
      echo $_SESSION['add'];
      unset($_SESSION['add']);
    }

    if(isset($_SESSION['upload'])) {
      echo $_SESSION['upload'];
      unset($_SESSION['upload']);
    }
  ?>
  <br><br>

  <!-- Add Category Form Starts -->
  <form action="" method="POST" enctype="multipart/form-data">
    <table class="tbl-30">
      <tr>
        <td>Title: </td>
        <td>
          <input type="text" name="title" placeholder="Category Title">
        </td>
      </tr>

      <tr>
        <td>Select Image: </td>
        <td>
          <input type="file" name="image">
        </td>
      </tr>

      <tr>
        <td>Featured:</td>
        <td>
          <input type="radio" name="featured" value="Yes"> Yes
          <input type="radio" name="featured" value="No"> No
        </td>
      </tr>

      <tr> 
        <td>Active:</td>
        <td>
          <input type="radio" name="active" value="Yes"> Yes
          <input type="radio" name="active" value="No"> No
        </td>
      </tr>

      <tr>
        <td colspan="2">
          <input type="submit" name="submit" value="Add category" class="btn-secondary">
        </td>
      </tr>
    </table>
  </form>
  <!-- Add Category Form Ends -->

  <?php 
    if(isset($_POST["submit"])) {
        // Get form data
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $featured = isset($_POST["featured"]) ? $_POST["featured"] : "No";
        $active = isset($_POST["active"]) ? $_POST["active"] : "No";

        // Image upload
        $image_name = "";

        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
            $image_name = $_FILES['image']['name'];
            
            if($image_name!="")
            {
              
            }

            // Auto rename image
           // $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $ext=end(explode('.',$image_name));

            
            $image_name = "food_Category_".rand(000, 999).'.'.$ext;



            $source_path = $_FILES['image']['tmp_name'];
            $destination_path = "../images/category/".$image_name;

            $upload = move_uploaded_file($source_path, $destination_path);

            if($upload == false) {
                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                header("Location: ".SITEURL."admin/add-category.php");
                die();
            }
        }

        // Insert into database
        $sql = "INSERT INTO tbl_category SET
                title='$title',
                featured='$featured',
                image_name='$image_name',
                active='$active'";

        $res = mysqli_query($conn, $sql);

        if($res == true) {
            $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";
            header("Location: ".SITEURL."admin/manage-category.php");
        } else {
            $_SESSION['add'] = "<div class='error'>Failed to add category.</div>";
            header("Location: ".SITEURL."admin/add-category.php");
        }
    }
  ?>

<?php include("partials/footer.php"); ?>
</div>

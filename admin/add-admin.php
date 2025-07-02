<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">

        <br />
        <h1>Add Admin</h1>
        <br /><br />

        <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];//displaying
            unset($_SESSION['add']);//removing the session mesg 
        }

    ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter your password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

    </div>
</div>

<br /><br />
<?php include("partials/footer.php"); ?>

<?php  
    // Process the value from the form 
    if(isset($_POST['submit']))
    {
        // Get form data 
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sql = "INSERT INTO tbl_admin SET 
        full_name='$full_name',
        username='$username',
        password='$password'";
        
        // ✅ Execute query
         $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        // ✅ Check if the data is inserted or not 
        if($res == TRUE)
        {
           // echo "Data inserted successfully.";
           $_SESSION['add']="Admin added";
           header("location:".SITEURL."admin/manage-admin.php");
        }
        else
        {
           // echo "Failed to insert data.";
           $_SESSION['add']="failed to add";
           header("location:".SITEURL."admin/add-admin.php");
        }
    
    }
?>

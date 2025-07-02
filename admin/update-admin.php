<?php include("partials/menu.php");?>


    <div class="main-content">
        <div class="wrapper">
            <h1>Update admin</h1>

            <br /><br />

            <?php 
            $id = $_GET['id'];

            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            $res=mysqli_query($conn,$sql);
            if($res==TRUE){
                $count=mysqli_num_rows($res);
                if($count==1)
                {
                   // echo"admin availabe";
                   $row=mysqli_fetch_assoc($res);

                   $full_name=$row['full_name'];
                   $username=$row['username'];


                }
                else{
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }


            }

?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Full name: </td>
                        <td><input type="text" name="full_name" placeholder="Enter your name" value="<?php echo $full_name; ?>"></td>
                </tr>
                <tr>
                        <td>Username: </td>
                        <td><input type="text" name="username" placeholder="Enter your username" value="<?php echo $username ?>"></td>
                </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="submit" value="update admin" class="btn-secondary">
                        </td>
                    </tr>


                </table>
            </form>
        </div>
    </div>


<?php

if(isset($_POST['submit']))
{
    $id=$_POST['id'];
   $full_name=$_POST['full_name'];
   $username=$_POST['username'];

   $sql = "UPDATE tbl_Admin SET
   full_name= '$full_name',
   username= '$username'
   WHERE id= '$id'";

   $res=mysqli_query($conn,$sql);

   if($res==TRUE)
   {
        $_SESSION['update']="<div class='success'>Admin update succesfully.</div>";
        header("location:".SITEURL.'admin/manage-admin.php');
   }
   


    
}
  


?>



<?php include("partials/footer.php"); ?>
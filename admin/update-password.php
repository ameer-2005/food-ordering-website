<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>change password</h1>
        <br><br>

        <?php 
        if (isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
        
        ?>

        <form action="" method="POST"></form>

            <table class="tbl-30">
                <tr>
                    <td>old password:</td>
                    <td>
                    
                    <input type="password" name="old_password" placeholder="old password">
                    </td>
                </tr>

                <tr>
                    <td>new password</td>
                    <td>
                        <input type="password" name="new_password" placeholder="new password">
                    </td>
                </tr>

                <tr>
                <td>confirm password</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm password">
                    </td>
                </tr>

                <tr>
                <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" name="submit" value="change password" class="btn-secondary">
                        </td>
                </tr>

                



            </table>

    </div>
</div>

<?php 

     if (isset($_POST['submit']))
     {
        $id=$_POST['id'];
        $old_password=md5($_POST['old_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$password'";

        $res=mysqli_query($conn,$sql);

        if ($res==TRUE)
        {
            $count=mysqli_num_rows($res);

            if($count==1)
            {
                echo"user found";

            }
            else{
                $_SESSION["password-don't match"]= "<div class='error'>user not found.</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
     }
?>


<?php include('partials/footer.php');?>
<?php include("partials/menu.php"); ?>

<!-- Main section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br /><br />

        <?php 

            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];//displaying
                unset($_SESSION['add']);//removing the session mesg 
            }
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete']; unset($_SESSION['delete']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update']; unset($_SESSION['update']);
            }

            if(isset($_SESSION['user-not-found']))
            {
                echo $_SESSION['user-not-found'];
                unset($_SESSION['user-not-found']);
            }

            


        ?>
        <br /><br />


        <a href="add-admin.php" class="btn-primary">Add admin</a>
        <br /><br /><br />

        <table class="tbl-full">
            <tr> 
                <th>s.n</th>
                <th>Full Name</th>
                <th>username</th>
                <th>Actions</th>
            </tr>



            <?php 
                $sql ="SELECT * FROM tbl_admin";
                $res=mysqli_query($conn,$sql);

                if($res==TRUE)
                {
                    $count=mysqli_num_rows( $res );

                    $sn=1;

                    if($count>0)
                    {
                        while($rows=mysqli_fetch_array($res))
                        {
                            $id=$rows['id'];
                            $full_name=$rows['full_name'];
                            $username=$rows['username'];


                            ?>

                            <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">change password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">update admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">delete admin</a>

                </td>
            </tr>

         <?php 

                            
        }

            }
     else{

          }

     }

            ?>

            <tr>
                




        </table>

        
    </div>
</div>
<!-- Main section ends -->

 
<?php include("partials/footer.php"); ?>
<?php 

    include("../config/constants.php");

    //getting the id of admit to be deleted
    $id = $_GET['id'];

    //sql query to delete the admin

    $sql="DELETE FROM tbl_admin WHERE id= $id";

    //redirect to manage admin page with message 
    $res=mysqli_query($conn,$sql);

    //check weather the query executed succesfully
    if($res==TRUE)
    {
        echo 'admin deleted';
        $_SESSION['delete']="<div class='success'>Admin deleted ";

        header(header: 'location:'.SITEURL.'admin/manage-admin.php');
    }
    else{
       $_SESSION['delete']= "<div class='error'>ADMIN DELETING FAILED. try again.";
       header(header: 'location:'.SITEURL.'admin/manage-admin.php');

    }


?>
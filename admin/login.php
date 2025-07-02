<?php 
include("../config/constants.php"); 
?>

<html>
<head>
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>

        <?php 
        if(isset($_SESSION['login']))
        {
            echo $_SESSION['login'];
            unset($_SESSION['login']);
        }

        if(isset($_SESSION['no-login-message']))
        {
            echo $_SESSION['no-login-message'];
            unset($_SESSION['no-login-messagw']);
        }
        ?>
        <br><br>

        <form action="" method="POST" class="text-center">
            <div>
                <label for="username">Username:</label> <br>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <br>
            <div>
                <label for="password">Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <br>
            <input type="submit" name="submit" value="SUBMIT" class="btn-secondary">
            <br><br>
            <p class="text-center">Created by - <a href="http://www.ruhi.com">Ameerunnisa</a></p>
        </form>
    </div>
</body>
</html>

<?php 
// Check if the form has been submitted
if(isset($_POST["submit"]))
{ 
    // Get the form data
    $username = $_POST["username"];
    $password = md5($_POST["password"]); // Consider using md5($password) if hashed

    // Fix the SQL query (add closing quote)
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    $res = mysqli_query($conn, $sql);

    $count = mysqli_num_rows($res);

    if($count == 1)
    {
        $_SESSION['login'] = "<div class='success'>Login successful.</div>";
        $_SESSION["user"] = $username;
        header("location:".SITEURL."admin/");
    }
    else
    {
        $_SESSION['login'] = "<div class='error'>Login failed. Invalid credentials.</div>";
        header("location:".SITEURL."admin/login.php");
    }
}
?>

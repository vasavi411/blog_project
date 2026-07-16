<?php
include 'db.php';

$message = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE email='$email' 
            AND password='$password'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $message = "Login Successful!";
    }
    else
    {
        $message = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>User Login</h2>

<?php
if($message != "")
{
    echo "<h3>$message</h3>";
}
?>

<form method="POST">

    Email:
    <input type="email" name="email" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    <input type="submit" name="login" value="Login">

</form>

</body>
</html>
<?php
include 'db.php';

$message = "";

if(isset($_POST['register']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users(username,email,password)
            VALUES('$username','$email','$password')";

    if(mysqli_query($conn, $sql))
    {
        $message = "Registration Successful!";
    }
    else
    {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>

<h2>User Registration</h2>

<?php
if($message != "")
{
    echo "<h3>$message</h3>";
}
?>

<form method="POST">

    Username:
    <input type="text" name="username" required>
    <br><br>

    Email:
    <input type="email" name="email" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    <input type="submit" name="register" value="Register">

</form>

</body>
</html>
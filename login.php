<?php
session_start();
include 'db.php';

$message = "";

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users 
            WHERE email='$email' 
            AND password='$password'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0)
    {
        $_SESSION['email'] = $email;

        header("Location: index.php");
        exit();
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

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .login-box {
            background-color: white;
            padding: 30px;
            width: 350px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        input[type="email"],
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
        }

        input[type="submit"] {
            padding: 10px 25px;
            margin-top: 10px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>User Login</h2>

    <?php
    if($message != "")
    {
        echo "<h3>$message</h3>";
    }
    ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>
        <br>

        <input type="password" name="password" placeholder="Password" required>
        <br>

        <input type="submit" name="login" value="Login">

    </form>

    <p>Don't have an account? 
        <a href="register.php">Register here</a>
    </p>

</div>

</body>
</html>
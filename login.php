<?php
session_start();
include 'db.php';

$message = "";

if(isset($_POST['login']))
{
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Server-side Validation
    if(empty($email) || empty($password))
    {
        $message = "All fields are required!";
    }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $message = "Invalid Email Format!";
    }
    else
    {
        // Prepared Statement
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? AND password = ?");

        mysqli_stmt_bind_param($stmt, "ss", $email, $password);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0)
        {
            // Fetch logged in user
            $user = mysqli_fetch_assoc($result);

            // Store session data
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit();
        }
        else
        {
            $message = "Invalid Email or Password!";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            background:#f2f2f2;
            margin:0;
        }

        .login-box{
            background:white;
            width:350px;
            padding:30px;
            border-radius:10px;
            text-align:center;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        input[type=email],
        input[type=password]{
            width:90%;
            padding:10px;
            margin:8px 0;
        }

        input[type=submit]{
            padding:10px 25px;
            cursor:pointer;
            margin-top:10px;
        }

        h3{
            color:red;
        }

        a{
            text-decoration:none;
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

<input
type="email"
name="email"
placeholder="Email"
required>

<br>

<input
type="password"
name="password"
placeholder="Password"
required>

<br>

<input
type="submit"
name="login"
value="Login">

</form>

<p>
Don't have an account?
<a href="register.php">Register here</a>
</p>

</div>

</body>
</html>
<?php
session_start();
include 'db.php';

$message = "";

if(isset($_SESSION['email']))
{
    header("Location: index.php");
    exit();
}

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
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($result && mysqli_num_rows($result) > 0)
        {
            $user = mysqli_fetch_assoc($result);
            

            if(password_verify($password, $user['password']))
            {
                // Store session data
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                header("Location: index.php");
                exit();
            }
        }

        $message = "Invalid Email or Password!";

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    font-family: Arial, sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    margin:0;
}

.login-box{
    background:white;
    width:420px;
    padding:35px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.login-box h2{
    text-align:center;
    margin-bottom:25px;
    font-weight:bold;
}

.input-group{
    margin-bottom:20px;
}

.btn-login{
    width:100%;
}
.btn-login:hover{
    transform: scale(1.03);
    transition:0.3s;
}

.error{
    color:red;
    text-align:center;
    margin-bottom:15px;
}

.register-link{
    text-align:center;
    margin-top:20px;
}
    </style>

</head>

<body>

<div class="login-box">

<div class="text-center mb-4">

<i class="bi bi-journal-bookmark-fill text-primary" style="font-size:60px;"></i>

<h2 class="mt-3">Blog Management System</h2>

<p class="text-muted">Login to continue</p>

</div>

<?php
if($message != "")
{
    echo "<div class='alert alert-danger'>$message</div>";
}
?>

<form method="POST">

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-envelope-fill"></i>
</span>

<input
type="email"
name="email"
class="form-control"
placeholder="Enter Email"
required>

</div>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-lock-fill"></i>
</span>

<input
type="password"
name="password"
id="password"
class="form-control"
placeholder="Enter Password"
required>

<button
class="btn btn-outline-secondary"
type="button"
onclick="togglePassword()">

<i class="bi bi-eye"></i>

</button>

</div>

<button
type="submit"
name="login"
class="btn btn-primary btn-login">

<i class="bi bi-box-arrow-in-right"></i>
 Login

</button>

</form>

<div class="register-link">

Don't have an account?

<a href="register.php">

Register Here

</a>

</div>



</div>

<script>

function togglePassword()
{
    var pass = document.getElementById("password");

    if(pass.type == "password")
    {
        pass.type = "text";
    }
    else
    {
        pass.type = "password";
    }
}

</script>

</body>
</html>


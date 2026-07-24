<?php
include 'db.php';

$message = "";

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Server-side Validation
    if(empty($username) || empty($email) || empty($password))
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
        $stmt = mysqli_prepare($conn, "INSERT INTO users(username, email, password) VALUES (?, ?, ?)");

        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);

        if(mysqli_stmt_execute($stmt))
        {
            $message = "Registration Successful!";
        }
        else
        {
            $message = "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
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

.register-box{
    background:white;
    width:420px;
    padding:35px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);
}

.input-group{
    margin-bottom:20px;
}

.btn-register{
    width:100%;
}

.btn-register:hover{
    transform:scale(1.03);
    transition:.3s;
}

.register-link{
    text-align:center;
    margin-top:20px;
}
    </style>
</head>

<body>

<div class="register-box">

    <div class="text-center mb-4">

<i class="bi bi-person-plus-fill text-primary" style="font-size:60px;"></i>

<h2 class="mt-3">Create Account</h2>

<p class="text-muted">Register to continue</p>

</div>

    <?php
    if($message != "")
    {
        echo "<div class='alert alert-success'>$message</div>";
    }
    ?>
<form method="POST">

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-person-fill"></i>
</span>

<input
type="text"
name="username"
class="form-control"
placeholder="Enter Username"
required>

</div>

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
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword()">

<i class="bi bi-eye"></i>

</button>

</div>

<button
type="submit"
name="register"
class="btn btn-success btn-register">

<i class="bi bi-person-plus"></i>
 Register

</button>

</form>

    <div class="register-link">

Already have an account?

<a href="login.php">

Login Here

</a>

</div>

</div>
<script>

function togglePassword()
{
    var pass=document.getElementById("password");

    if(pass.type=="password")
    {
        pass.type="text";
    }
    else
    {
        pass.type="password";
    }
}

</script>

</body>
</html>
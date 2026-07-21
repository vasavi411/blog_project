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

        .register-box {
            background-color: white;
            padding: 30px;
            width: 350px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        input[type="text"],
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

        h3 {
            color: green;
        }
    </style>
</head>

<body>

<div class="register-box">

    <h2>User Registration</h2>

    <?php
    if($message != "")
    {
        echo "<h3>$message</h3>";
    }
    ?>

    <form method="POST">

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <br>

        <input type="email"
               name="email"
               placeholder="Email"
               required>

        <br>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <br>

        <input type="submit"
               name="register"
               value="Register">

    </form>

    <p>
        Already have an account?
        <a href="login.php">Login here</a>
    </p>

</div>

</body>
</html>
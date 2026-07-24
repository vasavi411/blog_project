<?php
session_start();

if(!isset($_SESSION['email']))
{
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != "admin")
{
    header("Location: index.php");
    exit();
}
   
include 'db.php';
$message = "";

$id = $_GET['id'];

// Get user details
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);


// Update User

if(isset($_POST['update']))
{
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    if(empty($username) || empty($email) || empty($role))
{
    $message = "All fields are required!";
}
else
{
    $stmt = mysqli_prepare($conn,
    "UPDATE users
    SET username=?, email=?, role=?
    WHERE id=?");

    mysqli_stmt_bind_param(
    $stmt,
    "sssi",
    $username,
    $email,
    $role,
    $id
    );

   if(mysqli_stmt_execute($stmt))
{
    mysqli_stmt_close($stmt);
    header("Location: manage_users.php");
    exit();
}
else
{
    $message = "Failed to update user!";
}

mysqli_stmt_close($stmt);
}

   
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<title>Edit User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h3>
<i class="bi bi-person-gear"></i>
Edit User Details
</h3>

</div>

<div class="card-body">
<?php
if($message != "")
{
    echo "<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'>
    $message
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
}
?>


<form method="POST">

<div class="mb-3">

<label class="form-label">
Username
</label>

<input
type="text"
name="username"
class="form-control"
value="<?php echo $user['username']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Email
</label>

<input
type="email"
name="email"
class="form-control"
value="<?php echo $user['email']; ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">
Role
</label>

<select name="role" class="form-select">

<option value="admin"
<?php if($user['role']=="admin") echo "selected"; ?>>

Admin

</option>

<option value="user"
<?php if($user['role']=="user") echo "selected"; ?>>

User

</option>

</select>

</div>

<input type="submit"
name="update"
value="Update User"
class="btn btn-success">

<a href="manage_users.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
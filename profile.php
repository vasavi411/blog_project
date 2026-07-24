<?php
session_start();

if(!isset($_SESSION['email']))
{
    header("Location: login.php");
    exit();
}

include 'db.php';

$email=$_SESSION['email'];

$stmt=mysqli_prepare($conn,"SELECT * FROM users WHERE email=?");
mysqli_stmt_bind_param($stmt,"s",$email);
mysqli_stmt_execute($stmt);

$result=mysqli_stmt_get_result($stmt);

$user=mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>

<html>

<head>

<title>Profile</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h3>

<i class="bi bi-person-circle"></i>

My Profile

</h3>

</div>

<div class="card-body">

<p>
<i class="bi bi-person-fill text-primary"></i>
<b>Username :</b>
<?php echo $user['username']; ?>
</p>

<p>
<i class="bi bi-envelope-fill text-success"></i>
<b>Email :</b>
<?php echo $user['email']; ?>
</p>

<p>
<i class="bi bi-shield-lock-fill text-danger"></i>
<b>Role :</b>
<?php echo ucfirst($user['role']); ?>
</p>

<?php
if($_SESSION['role']=="admin")
{
?>

<a href="dashboard.php" class="btn btn-primary">
    <i class="bi bi-arrow-left"></i>
    Back to Dashboard
</a>

<?php
}
else
{
?>

<a href="index.php" class="btn btn-primary">
    <i class="bi bi-arrow-left"></i>
    Back to Home
</a>

<?php
}
?>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
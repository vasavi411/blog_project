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

$result = mysqli_query($conn,"SELECT * FROM users");
?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Users</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">

<div class="container mt-5">

<h2 class="mb-4">
👥 Manage Users
</h2>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Username</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
<th>Delete</th>

</tr>

</thead>

<tbody>

<?php
while($row=mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['username']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo ucfirst($row['role']); ?></td>
<td>
    <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
        <i class="bi bi-pencil-square"></i> Edit
    </a>
</td>
<td>

<?php
if($row['email'] != $_SESSION['email'])
{
?>

<a href="delete_user.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this user?')">

<i class="bi bi-trash"></i>

Delete

</a>

<?php
}
else
{
    echo "<span class='badge bg-success'>Current User</span>";
}
?>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

<a href="dashboard.php" class="btn btn-primary">
    <i class="bi bi-arrow-left"></i>
    Back to Dashboard
</a>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
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
$email = $_SESSION['email'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email=?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
// Total Users
$user_query = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$user_data = mysqli_fetch_assoc($user_query);

// Total Posts
$post_query = mysqli_query($conn, "SELECT COUNT(*) AS total_posts FROM posts");
$post_data = mysqli_fetch_assoc($post_query);
// Recent Posts
$recent_posts = mysqli_query($conn,
"SELECT title, created_at FROM posts ORDER BY id DESC LIMIT 5");
// Admin Count
$admin_query = mysqli_query($conn,
"SELECT COUNT(*) AS total_admin FROM users WHERE role='admin'");
$admin_data = mysqli_fetch_assoc($admin_query);

// Normal User Count
$user_query2 = mysqli_query($conn,
"SELECT COUNT(*) AS total_member FROM users WHERE role='user'");
$user_data2 = mysqli_fetch_assoc($user_query2);
?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="#">
            Blog Admin Dashboard
        </a>

        <div>

            <a href="index.php" class="btn btn-outline-light me-2">
    <i class="bi bi-house"></i> Home
</a>

<a href="create.php" class="btn btn-success me-2">
    <i class="bi bi-plus-circle"></i> Create Post
</a>
<a href="profile.php" class="btn btn-warning me-2">
    <i class="bi bi-person-circle"></i> Profile
</a>

<a href="logout.php" class="btn btn-danger">
    <i class="bi bi-box-arrow-right"></i> Logout
</a>

        </div>

    </div>
</nav>

<div class="container mt-5">

<div class="card shadow mb-4">

<div class="card-body">

<h2>
👋 Welcome,
<?php echo ucfirst($user['username']); ?>
</h2>

<p class="text-muted">
You are logged in as
<b><?php echo ucfirst($_SESSION['role']); ?></b>.
Manage your blog from this dashboard.
</p>

</div>

</div>

<div class="row">

<div class="col-md-6">

<div class="card text-white bg-primary shadow">

<div class="card-body text-center">

<h1>
<i class="bi bi-people-fill"></i>
</h1>

<h3>
<?php echo $user_data['total_users']; ?>
</h3>

<h5>Total Users</h5>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card text-white bg-success shadow">

<div class="card-body text-center">

<h1>
<i class="bi bi-file-earmark-text-fill"></i>
</h1>

<h3>
<?php echo $post_data['total_posts']; ?>
</h3>

<h5>Total Posts</h5>

</div>

</div>

</div>
</div>
<div class="row mt-4">

<div class="col-md-6">

<div class="card text-white bg-warning shadow">

<div class="card-body text-center">

<h1>
<i class="bi bi-shield-lock-fill"></i>
</h1>

<h3>
<?php echo $admin_data['total_admin']; ?>
</h3>

<h5>Admin Users</h5>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card text-white bg-danger shadow">

<div class="card-body text-center">

<h1>
<i class="bi bi-person-fill"></i>
</h1>

<h3>
<?php echo $user_data2['total_member']; ?>
</h3>

<h5>Normal Users</h5>

</div>

</div>

</div>

</div>

<div class="text-center mt-4">

<a href="index.php" class="btn btn-primary">
Back to Blog
</a>

</div>
<hr class="my-5">

<h3 class="mb-3">
Recent Posts
</h3>
<!-- Quick Actions -->

<div class="card shadow mt-5">

<div class="card-header bg-secondary text-white">

<h4>
⚡ Quick Actions
</h4>

</div>

<div class="card-body text-center">

<a href="create.php" class="btn btn-success m-2">
<i class="bi bi-plus-circle"></i>
New Post
</a>

<a href="index.php" class="btn btn-primary m-2">
<i class="bi bi-card-list"></i>
View Posts
</a>

<a href="profile.php" class="btn btn-warning m-2">
    <i class="bi bi-person-circle"></i>
    Profile
</a>

<a href="manage_users.php" class="btn btn-info m-2">
    <i class="bi bi-people-fill"></i>
    Manage Users
</a>

<a href="logout.php" class="btn btn-danger m-2">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</div>

</div>
<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>Title</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php
while($row=mysqli_fetch_assoc($recent_posts))
{
?>

<tr>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['created_at']; ?></td>

</tr>

<?php
}
?>

</tbody>

</table>
</div>

</body>
</html>
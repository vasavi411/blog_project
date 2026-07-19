<?php
session_start();
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM posts");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Project</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .nav {
            text-align: center;
            padding: 20px;
        }

        .nav a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            background-color: #333;
            color: white;
            border-radius: 5px;
        }

        .post {
            background-color: white;
            width: 70%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }

        .post a {
            margin-right: 15px;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="header">
    <h1>Blog Project</h1>
    <p>Welcome to the Blog</p>
</div>

<div class="nav">
    <a href="create.php">Create New Post</a>
    <a href="logout.php">Logout</a>
</div>

<h2 style="text-align:center;">All Blog Posts</h2>

<?php
while($row = mysqli_fetch_assoc($result))
{
?>

<div class="post">

    <h3><?php echo $row['title']; ?></h3>

    <p><?php echo $row['content']; ?></p>

    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>

    <a href="delete.php?id=<?php echo $row['id']; ?>"
       onclick="return confirm('Are you sure you want to delete this post?');">
       Delete
    </a>

</div>

<?php
}
?>

</body>
</html>
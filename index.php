<?php
session_start();

if(!isset($_SESSION['email']))
{
    header("Location: login.php");
    exit();
}

include 'db.php';

/* Number of posts per page */
$limit = 2;

/* Current page */
if(isset($_GET['page']))
{
    $page = $_GET['page'];
}
else
{
    $page = 1;
}

/* Starting record */
$start = ($page - 1) * $limit;

/* Search */
if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = $_GET['search'];

    $sql = "SELECT * FROM posts
            WHERE title LIKE '%$search%'
            OR content LIKE '%$search%'
            LIMIT $start, $limit";

    $count_sql = "SELECT COUNT(*) AS total
                  FROM posts
                  WHERE title LIKE '%$search%'
                  OR content LIKE '%$search%'";
}
else
{
    $sql = "SELECT * FROM posts
            LIMIT $start, $limit";

    $count_sql = "SELECT COUNT(*) AS total
                  FROM posts";
}

$result = mysqli_query($conn, $sql);

$count_result = mysqli_query($conn, $count_sql);
$count_row = mysqli_fetch_assoc($count_result);

$total_posts = $count_row['total'];

$total_pages = ceil($total_posts / $limit);
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

        .search-box {
            text-align: center;
            margin: 20px;
        }

        .search-box input[type="text"] {
            width: 300px;
            padding: 10px;
        }

        .search-box input[type="submit"] {
            padding: 10px 20px;
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
            color: blue;
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

<div class="search-box">
    <form method="GET">
        <input type="text" name="search" placeholder="Search by title or content"
        value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
        <input type="submit" value="Search">
    </form>
</div>

<?php
if(mysqli_num_rows($result) > 0)
{
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
}
else
{
    echo "<h2 style='text-align:center;color:red;'>No Posts Found!</h2>";
}
?>

<!-- Pagination Starts -->

<div style="text-align:center; margin:30px;">

<?php

if($page > 1)
{
?>

<a href="?page=<?php echo $page-1; ?>&search=<?php echo isset($search)?$search:''; ?>"
style="padding:10px 15px;
background:#333;
color:white;
text-decoration:none;
border-radius:5px;">
Previous
</a>

<?php
}

for($i=1; $i<=$total_pages; $i++)
{
?>

<a href="?page=<?php echo $i; ?>&search=<?php echo isset($search)?$search:''; ?>"
style="padding:10px 15px;
margin:5px;
border:1px solid black;
text-decoration:none;
<?php if($page==$i){ ?>
background:#333;
color:white;
<?php } ?>">
<?php echo $i; ?>
</a>

<?php
}

if($page < $total_pages)
{
?>

<a href="?page=<?php echo $page+1; ?>&search=<?php echo isset($search)?$search:''; ?>"
style="padding:10px 15px;
background:#333;
color:white;
text-decoration:none;
border-radius:5px;">
Next
</a>

<?php
}
?>

</div>

</body>
</html>
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

/* Search with Prepared Statements */
if(isset($_GET['search']) && trim($_GET['search']) != "")
{
    $search = trim($_GET['search']);
    $like = "%" . $search . "%";

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM posts
         WHERE title LIKE ? OR content LIKE ?
         LIMIT ?, ?");

    mysqli_stmt_bind_param($stmt, "ssii", $like, $like, $start, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $count_stmt = mysqli_prepare($conn,
        "SELECT COUNT(*) AS total
         FROM posts
         WHERE title LIKE ? OR content LIKE ?");

    mysqli_stmt_bind_param($count_stmt, "ss", $like, $like);
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
}
else
{
    $stmt = mysqli_prepare($conn,
        "SELECT * FROM posts LIMIT ?, ?");

    mysqli_stmt_bind_param($stmt, "ii", $start, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $count_stmt = mysqli_prepare($conn,
        "SELECT COUNT(*) AS total FROM posts");

    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
}

$count_row = mysqli_fetch_assoc($count_result);

$total_posts = $count_row['total'];

$total_pages = ceil($total_posts / $limit);


?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Project</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand" href="#">
<i class="bi bi-journal-bookmark-fill"></i>
 Blog Management System
</a>

<div>

<?php
if($_SESSION['role']=="admin")
{
?>

<a href="dashboard.php" class="btn btn-warning me-2">
<i class="bi bi-speedometer2"></i> Dashboard
</a>

<a href="create.php" class="btn btn-success me-2">
<i class="bi bi-plus-circle"></i> Create Post
</a>

<?php
}
?>

<a href="logout.php" class="btn btn-danger">
<i class="bi bi-box-arrow-right"></i> Logout
</a>

</div>

</div>

</nav>

<h2 class="text-center mt-4 mb-4">

<i class="bi bi-journal-text"></i>

All Blog Posts

</h2>

<div class="container mt-4">

<form method="GET" class="row g-2 justify-content-center">

<div class="col-md-6">

<input
type="text"
name="search"
class="form-control"
placeholder="🔍 Search posts..."

value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">

</div>

<div class="col-auto">

<button class="btn btn-primary">

<i class="bi bi-search"></i>

Search

</button>

</div>

</form>

</div>

<?php
if(mysqli_num_rows($result) > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-body">

<h3 class="card-title">
<i class="bi bi-file-earmark-text text-primary"></i>
<?php echo $row['title']; ?>
</h3>

<p class="card-text">
<?php echo $row['content']; ?>
</p>

    <?php
if($_SESSION['role'] == "admin")
{
?>

<a href="edit.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary">

<i class="bi bi-pencil-square"></i>
 Edit

</a>

<a href="delete.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger"
onclick="return confirm('Are you sure you want to delete this post?');">

<i class="bi bi-trash"></i>
 Delete

</a>

<?php
}
?>

</div> <!-- card-body -->

</div> <!-- card -->

</div> <!-- container -->

<?php
    }
}
else
{
    echo "<h2 style='text-align:center;color:red;'>No Posts Found!</h2>";
}
?>

<!-- Bootstrap Pagination -->

<nav class="mt-4">

<ul class="pagination justify-content-center">

<?php
if($page > 1)
{
?>

<li class="page-item">

<a class="page-link"
href="?page=<?php echo $page-1; ?>&search=<?php echo isset($search)?$search:''; ?>">

Previous

</a>

</li>

<?php
}

for($i=1; $i<=$total_pages; $i++)
{
?>

<li class="page-item <?php if($page==$i) echo 'active'; ?>">

<a class="page-link"
href="?page=<?php echo $i; ?>&search=<?php echo isset($search)?$search:''; ?>">

<?php echo $i; ?>

</a>

</li>

<?php
}

if($page < $total_pages)
{
?>

<li class="page-item">

<a class="page-link"
href="?page=<?php echo $page+1; ?>&search=<?php echo isset($search)?$search:''; ?>">

Next

</a>

</li>

<?php
}
?>

</ul>

</nav>

</body>
</html>
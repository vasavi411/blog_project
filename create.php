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

if(isset($_POST['submit']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side Validation
    if(empty($title) || empty($content))
    {
        $message = "All fields are required!";
    }
    else
    {
        // Prepared Statement
        $stmt = mysqli_prepare($conn, "INSERT INTO posts(title, content) VALUES (?, ?)");

        mysqli_stmt_bind_param($stmt, "ss", $title, $content);

        if(mysqli_stmt_execute($stmt))
        {
            $message = "Post Added Successfully!";
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
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    font-family:Arial,sans-serif;
}

        .card{
    border-radius:15px;
}
    </style>

</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-body">

<h2 class="text-center mb-4">

<i class="bi bi-plus-circle-fill text-success"></i>

Create Blog Post

</h2>

<?php
if($message != "")
{
    echo "<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>
$message
<button type='button' class='btn-close' data-bs-dismiss='alert'></button>
</div>";
}
?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Post Title

</label>

<input
type="text"
name="title"
class="form-control"
placeholder="Enter Post Title"
required
maxlength="100">

</div>

<div class="mb-3">

<label class="form-label">

Content

</label>

<textarea
name="content"
class="form-control"
rows="6"
placeholder="Enter Post Content"
required>

</textarea>

</div>


<button
type="submit"
name="submit"
class="btn btn-success w-100">

<i class="bi bi-plus-circle"></i>

Publish Post

</button>

</form>

<div class="text-center mt-3">

<a href="index.php" class="btn btn-secondary">

<i class="bi bi-arrow-left"></i>

Back to Posts

</a>

</div>

</div>

</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
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

/* Get post details */
if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $post = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
}

/* Update post */
if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side Validation
    if(empty($title) || empty($content))
    {
        $message = "All fields are required!";
    }
    else
    {
        $stmt = mysqli_prepare($conn, "UPDATE posts SET title = ?, content = ? WHERE id = ?");

        mysqli_stmt_bind_param($stmt, "ssi", $title, $content, $id);

        if(mysqli_stmt_execute($stmt))
        {
            mysqli_stmt_close($stmt);
            header("Location: index.php");
            exit();
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
    <title>Edit Post</title>
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

<i class="bi bi-pencil-square text-primary"></i>

Edit Blog Post

</h2>

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

<input type="hidden" name="id" value="<?php echo $post['id']; ?>">

<div class="mb-3">

<label class="form-label">

Post Title

</label>

<input
type="text"
name="title"
class="form-control"
value="<?php echo $post['title']; ?>"
required
maxlength="100">

</div>

<br>

<div class="mb-3">

<label class="form-label">

Content

</label>

<textarea
name="content"
class="form-control"
rows="6"
required><?php echo $post['content']; ?></textarea>

</div>

<br>

<button
type="submit"
name="update"
class="btn btn-primary w-100">

<i class="bi bi-pencil-square"></i>

Update Post

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
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

    <style>
        body{
            font-family:Arial,sans-serif;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            margin:0;
            background:#f2f2f2;
        }

        .edit-box{
            background:white;
            width:400px;
            padding:30px;
            text-align:center;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        input[type="text"],
        textarea{
            width:90%;
            padding:10px;
            margin:8px 0;
        }

        textarea{
            height:120px;
        }

        input[type="submit"]{
            padding:10px 25px;
            margin-top:10px;
            cursor:pointer;
        }

        a{
            text-decoration:none;
        }

        h3{
            color:red;
        }
    </style>

</head>

<body>

<div class="edit-box">

<h2>Edit Blog Post</h2>

<?php
if($message!="")
{
    echo "<h3>$message</h3>";
}
?>

<form method="POST">

<input type="hidden" name="id" value="<?php echo $post['id']; ?>">

<input
type="text"
name="title"
value="<?php echo $post['title']; ?>"
required
maxlength="100">

<br>

<textarea
name="content"
required><?php echo $post['content']; ?></textarea>

<br>

<input
type="submit"
name="update"
value="Update Post">

</form>

<p>
<a href="index.php">Back to All Blog Posts</a>
</p>

</div>

</body>
</html>
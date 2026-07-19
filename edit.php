<?php
include 'db.php';

$message = "";

/* Get post details */
if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT * FROM posts WHERE id='$id'");
    $post = mysqli_fetch_assoc($result);
}

/* Update post */
if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts
            SET title='$title',
                content='$content'
            WHERE id='$id'";

    if(mysqli_query($conn, $sql))
    {
        header("Location: index.php");
        exit();
    }
    else
    {
        $message = "Error!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }

        .edit-box {
            background-color: white;
            padding: 30px;
            width: 400px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        input[type="text"],
        textarea {
            width: 90%;
            padding: 10px;
            margin: 8px 0;
        }

        textarea {
            height: 120px;
        }

        input[type="submit"] {
            padding: 10px 25px;
            margin-top: 10px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="edit-box">

    <h2>Edit Blog Post</h2>

    <?php
    if($message != "")
    {
        echo "<h3>$message</h3>";
    }
    ?>

    <form method="POST">

        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">

        <input type="text" name="title"
               value="<?php echo $post['title']; ?>" required>
        <br>

        <textarea name="content" required><?php echo $post['content']; ?></textarea>
        <br>

        <input type="submit" name="update" value="Update Post">

    </form>

    <p>
        <a href="index.php">Back to All Blog Posts</a>
    </p>

</div>

</body>
</html>
<?php
include 'db.php';

$message = "";

if(isset($_POST['submit']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title,content)
            VALUES('$title','$content')";

    if(mysqli_query($conn,$sql))
    {
        $message = "Post Added Successfully!";
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
    <title>Create Post</title>

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

        .create-box {
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

<div class="create-box">

    <h2>Create Blog Post</h2>

    <?php
    if($message != "")
    {
        echo "<h3>$message</h3>";
    }
    ?>

    <form method="POST">

        <input type="text" name="title" placeholder="Enter Post Title" required>
        <br>

        <textarea name="content" placeholder="Enter Post Content" required></textarea>
        <br>

        <input type="submit" name="submit" value="Add Post">

    </form>

    <p>
        <a href="index.php">Back to All Blog Posts</a>
    </p>

</div>

</body>
</html>
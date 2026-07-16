<?php
include "db.php";

if(isset($_POST['delete']))
{
    $id = $_POST['id'];

    $sql = "DELETE FROM posts WHERE id=$id";

    if(mysqli_query($conn, $sql))
    {
        echo "Post Deleted Successfully!";
    }
    else
    {
        echo "Error deleting post";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Post</title>
</head>
<body>

<h2>Delete Blog Post</h2>

<form method="POST">
    Post ID:
    <input type="number" name="id" required>
    <br><br>

    <input type="submit" name="delete" value="Delete Post">
</form>

</body>
</html>
<?php
include 'db.php';

$message = "";

if(isset($_POST['update']))
{
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts
            SET title='$title',
                content='$content'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql))
    {
        $message = "Post Updated Successfully!";
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
</head>
<body>

<h2>Edit Blog Post</h2>

<?php
echo "<h3>$message</h3>";
?>

<form method="POST">

    Post ID:
    <input type="number" name="id" required>
    <br><br>

    New Title:
    <input type="text" name="title" required>
    <br><br>

    New Content:
    <textarea name="content" required></textarea>
    <br><br>

    <input type="submit" name="update" value="Update Post">

</form>

</body>
</html>
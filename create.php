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
</head>
<body>

<h2>Create Blog Post</h2>

<?php
if($message != "")
{
    echo "<h3>$message</h3>";
}
?>

<form method="POST">

    Title:
    <input type="text" name="title" required>
    <br><br>

    Content:
    <textarea name="content" required></textarea>
    <br><br>

    <input type="submit" name="submit" value="Add Post">

</form>

</body>
</html>
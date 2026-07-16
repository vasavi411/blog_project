<?php
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM posts");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
</head>
<body>

<h2>All Blog Posts</h2>

<?php
while($row = mysqli_fetch_assoc($result))
{
    echo "<h3>" . $row['title'] . "</h3>";
    echo "<p>" . $row['content'] . "</p>";
    echo "<hr>";
}
?>

</body>
</html>
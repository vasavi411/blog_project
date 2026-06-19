<!DOCTYPE html>
<html>
<body>

<form method="post">
    Enter Your Name:
    <input type="text" name="username">
    <input type="submit" value="Submit">
</form>

<?php
if(isset($_POST['username']))
{
    echo "<h2>Hello " . $_POST['username'] . "</h2>";
}
?>

</body>
</html>
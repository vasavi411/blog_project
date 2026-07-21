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

include "db.php";

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    // Prepared Statement
    $stmt = mysqli_prepare($conn, "DELETE FROM posts WHERE id = ?");

    mysqli_stmt_bind_param($stmt, "i", $id);

    if(mysqli_stmt_execute($stmt))
    {
        mysqli_stmt_close($stmt);
        header("Location: index.php");
        exit();
    }
    else
    {
        echo "Error deleting post.";
    }

    mysqli_stmt_close($stmt);
}
else
{
    echo "Invalid Post ID.";
}
?>
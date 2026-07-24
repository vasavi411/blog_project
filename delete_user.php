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

$id = $_GET['id'];

// Prevent deleting yourself
$stmt = mysqli_prepare($conn, "SELECT email FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if($user['email'] != $_SESSION['email'])
{
    $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
}

header("Location: manage_users.php");
exit();
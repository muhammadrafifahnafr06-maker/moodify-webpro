<?php
session_start();
include 'config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

mysqli_query(
$conn,
"DELETE FROM my_diary
WHERE id_diary='$id'
AND id_user='$id_user'"
);

header("Location: mydiary.php");
exit;
?>
<?php
session_start();
include 'config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$judul = mysqli_real_escape_string($conn,$_POST['judul']);
$isi = mysqli_real_escape_string($conn,$_POST['isi']);

$tanggal = date("Y-m-d");

mysqli_query(
$conn,
"INSERT INTO my_diary
(id_user,judul,isi_diary,tanggal)
VALUES
('$id_user','$judul','$isi','$tanggal')"
);

header("Location: mydiary.php");
exit;
?>

<?php
session_start();
include 'Config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

if (isset($_POST['judul']) && isset($_POST['isi'])) {
    $id_user = $_SESSION['user_id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $isi_diary = mysqli_real_escape_string($conn, $_POST['isi']);
    $tanggal = date('Y-m-d');

    $query = "INSERT INTO my_diary (id_user, judul, isi_diary, tanggal) VALUES ('$id_user', '$judul', '$isi_diary', '$tanggal')";

    if (mysqli_query($conn, $query)) {
        header("Location: mydiary.php");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
} else {
    header("Location: mydiary.php");
    exit();
}
?>
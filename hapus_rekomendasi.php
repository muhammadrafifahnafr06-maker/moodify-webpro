<?php
include 'Config.php';

$id = $_GET['id'];

$query = "DELETE FROM rekomendasi_mood WHERE id_rekomendasi = '$id'";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Rekomendasi berhasil dihapus!'); window.location='admin_rekomendasi.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus rekomendasi!'); window.location='admin_rekomendasi.php';</script>";
}
?>
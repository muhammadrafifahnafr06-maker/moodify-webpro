<?php
include 'Config.php';

$id = $_GET['id'];

$query = "DELETE FROM aktivitas_harian WHERE id_aktivitas = '$id'";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Aktivitas berhasil dihapus!'); window.location='admin_aktivitas.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus aktivitas!'); window.location='admin_aktivitas.php';</script>";
}
?>
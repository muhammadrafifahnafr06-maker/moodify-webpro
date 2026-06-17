<?php
include 'Config.php';

if (isset($_POST['simpan'])) {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $durasi_tidur = mysqli_real_escape_string($conn, $_POST['durasi_tidur']);
    $aktivitas_fisik = mysqli_real_escape_string($conn, $_POST['aktivitas_fisik']);
    $tingkat_stres = mysqli_real_escape_string($conn, $_POST['tingkat_stres']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    $query = "INSERT INTO aktivitas_harian 
              (tanggal, durasi_tidur, aktivitas_fisik, tingkat_stres, catatan)
              VALUES 
              ('$tanggal', '$durasi_tidur', '$aktivitas_fisik', '$tingkat_stres', '$catatan')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Aktivitas berhasil ditambahkan!'); window.location='admin_aktivitas.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan aktivitas!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Aktivitas</title>
    <link rel="stylesheet" href="style_moodtracker.css">
</head>
<body>

<div class="navbar">
    <div class="logo">Moodify</div>
    <div class="nav">
        <a href="suasana_hati.php">Suasana Hati</a>
        <a href="mydiary.php">My Diary</a>
        <a href="kotakrahasia.php">Kotak Rahasia</a>
        <a href="admin_aktivitas.php" class="active">Mood Tracker</a>
        <a href="Logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="box">
        <h1>Tambah Aktivitas Harian</h1>
        <p class="subtitle">Masukkan aktivitas harian yang memengaruhi suasana hati</p>

        <form method="POST">
            <label>Tanggal</label>
            <input type="date" name="tanggal" required>

            <label>Durasi Tidur</label>
            <input type="number" name="durasi_tidur" placeholder="Contoh: 7" required>

            <label>Aktivitas Fisik</label>
            <input type="text" name="aktivitas_fisik" placeholder="Contoh: Jalan kaki, olahraga, kuliah" required>

            <label>Tingkat Stres</label>
            <select name="tingkat_stres" required>
                <option value="">Pilih tingkat stres</option>
                <option value="Rendah">Rendah</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>

            <label>Catatan</label>
            <textarea name="catatan" placeholder="Tulis catatan aktivitas hari ini..."></textarea>

            <button type="submit" name="simpan" class="btn">Simpan Aktivitas</button>
            <a href="admin_aktivitas.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

</body>
</html>
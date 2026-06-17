<?php
include 'Config.php';

if (isset($_POST['simpan'])) {
    $mood_target = mysqli_real_escape_string($conn, $_POST['mood_target']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $isi_rekomendasi = mysqli_real_escape_string($conn, $_POST['isi_rekomendasi']);

    $query = "INSERT INTO rekomendasi_mood 
              (mood_target, judul, kategori, isi_rekomendasi)
              VALUES 
              ('$mood_target', '$judul', '$kategori', '$isi_rekomendasi')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Rekomendasi berhasil ditambahkan!'); window.location='admin_rekomendasi.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan rekomendasi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Rekomendasi</title>
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
        <h1>Tambah Rekomendasi Mood</h1>

        <form method="POST">
            <label>Mood Target</label>
            <select name="mood_target" required>
                <option value="">Pilih mood</option>
                <option value="Gembira">Gembira</option>
                <option value="Tenang">Tenang</option>
                <option value="Sedih">Sedih</option>
                <option value="Lelah">Lelah</option>
                <option value="Marah">Marah</option>
                <option value="Semangat">Semangat</option>
            </select>

            <label>Judul Rekomendasi</label>
            <input type="text" name="judul" placeholder="Contoh: Latihan pernapasan ringan" required>

            <label>Kategori</label>
            <input type="text" name="kategori" placeholder="Contoh: Relaksasi, Produktivitas, Istirahat" required>

            <label>Isi Rekomendasi</label>
            <textarea name="isi_rekomendasi" placeholder="Tulis isi rekomendasi..." required></textarea>

            <button type="submit" name="simpan" class="btn">Simpan Rekomendasi</button>
            <a href="admin_rekomendasi.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

</body>
</html>
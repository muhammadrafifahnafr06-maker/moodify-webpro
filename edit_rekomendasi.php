<?php
include 'Config.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM rekomendasi_mood WHERE id_rekomendasi = '$id'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='admin_rekomendasi.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $mood_target = mysqli_real_escape_string($conn, $_POST['mood_target']);
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $isi_rekomendasi = mysqli_real_escape_string($conn, $_POST['isi_rekomendasi']);

    $query = "UPDATE rekomendasi_mood SET
              mood_target = '$mood_target',
              judul = '$judul',
              kategori = '$kategori',
              isi_rekomendasi = '$isi_rekomendasi'
              WHERE id_rekomendasi = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Rekomendasi berhasil diperbarui!'); window.location='admin_rekomendasi.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui rekomendasi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Rekomendasi</title>
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
        <h1>Edit Rekomendasi Mood</h1>

        <form method="POST">
            <label>Mood Target</label>
            <select name="mood_target" required>
                <option value="Gembira" <?= $row['mood_target'] == 'Gembira' ? 'selected' : ''; ?>>Gembira</option>
                <option value="Tenang" <?= $row['mood_target'] == 'Tenang' ? 'selected' : ''; ?>>Tenang</option>
                <option value="Sedih" <?= $row['mood_target'] == 'Sedih' ? 'selected' : ''; ?>>Sedih</option>
                <option value="Lelah" <?= $row['mood_target'] == 'Lelah' ? 'selected' : ''; ?>>Lelah</option>
                <option value="Marah" <?= $row['mood_target'] == 'Marah' ? 'selected' : ''; ?>>Marah</option>
                <option value="Semangat" <?= $row['mood_target'] == 'Semangat' ? 'selected' : ''; ?>>Semangat</option>
            </select>

            <label>Judul Rekomendasi</label>
            <input type="text" name="judul" value="<?= htmlspecialchars($row['judul']); ?>" required>

            <label>Kategori</label>
            <input type="text" name="kategori" value="<?= htmlspecialchars($row['kategori']); ?>" required>

            <label>Isi Rekomendasi</label>
            <textarea name="isi_rekomendasi" required><?= htmlspecialchars($row['isi_rekomendasi']); ?></textarea>

            <button type="submit" name="update" class="btn">Update Rekomendasi</button>
            <a href="admin_rekomendasi.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

</body>
</html>
<?php
include 'Config.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM aktivitas_harian WHERE id_aktivitas = '$id'");
$row = mysqli_fetch_assoc($data);

if (!$row) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='admin_aktivitas.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $durasi_tidur = mysqli_real_escape_string($conn, $_POST['durasi_tidur']);
    $aktivitas_fisik = mysqli_real_escape_string($conn, $_POST['aktivitas_fisik']);
    $tingkat_stres = mysqli_real_escape_string($conn, $_POST['tingkat_stres']);
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    $query = "UPDATE aktivitas_harian SET
              tanggal = '$tanggal',
              durasi_tidur = '$durasi_tidur',
              aktivitas_fisik = '$aktivitas_fisik',
              tingkat_stres = '$tingkat_stres',
              catatan = '$catatan'
              WHERE id_aktivitas = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Aktivitas berhasil diperbarui!'); window.location='admin_aktivitas.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui aktivitas!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Aktivitas</title>
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
        <h1>Edit Aktivitas Harian</h1>

        <form method="POST">
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?= $row['tanggal']; ?>" required>

            <label>Durasi Tidur</label>
            <input type="number" name="durasi_tidur" value="<?= $row['durasi_tidur']; ?>" required>

            <label>Aktivitas Fisik</label>
            <input type="text" name="aktivitas_fisik" value="<?= htmlspecialchars($row['aktivitas_fisik']); ?>" required>

            <label>Tingkat Stres</label>
            <select name="tingkat_stres" required>
                <option value="Rendah" <?= $row['tingkat_stres'] == 'Rendah' ? 'selected' : ''; ?>>Rendah</option>
                <option value="Sedang" <?= $row['tingkat_stres'] == 'Sedang' ? 'selected' : ''; ?>>Sedang</option>
                <option value="Tinggi" <?= $row['tingkat_stres'] == 'Tinggi' ? 'selected' : ''; ?>>Tinggi</option>
            </select>

            <label>Catatan</label>
            <textarea name="catatan"><?= htmlspecialchars($row['catatan']); ?></textarea>

            <button type="submit" name="update" class="btn">Update Aktivitas</button>
            <a href="admin_aktivitas.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

</body>
</html>
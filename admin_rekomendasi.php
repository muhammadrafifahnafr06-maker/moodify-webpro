<?php
include 'Config.php';

$data = mysqli_query($conn, "SELECT * FROM rekomendasi_mood ORDER BY id_rekomendasi DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Moodify - Rekomendasi Mood</title>
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
    <h1>Rekomendasi Mood 💡</h1>
    <p class="subtitle">Kelola rekomendasi yang ditampilkan berdasarkan suasana hati pengguna</p>

    <div class="box">
        <a href="admin_aktivitas.php" class="btn btn-menu">Aktivitas Harian</a>
        <a href="admin_rekomendasi.php" class="btn btn-menu">Rekomendasi Mood</a>

        <h2>Data Rekomendasi Mood</h2>
        <a href="tambah_rekomendasi.php" class="btn">+ Tambah Rekomendasi</a>

        <table>
            <tr>
                <th>No</th>
                <th>Mood Target</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Isi Rekomendasi</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['mood_target']); ?></td>
                <td><?= htmlspecialchars($row['judul']); ?></td>
                <td><?= htmlspecialchars($row['kategori']); ?></td>
                <td><?= htmlspecialchars($row['isi_rekomendasi']); ?></td>
                <td>
                    <a class="btn-edit" href="edit_rekomendasi.php?id=<?= $row['id_rekomendasi']; ?>">Edit</a>
                    <a class="btn-delete" href="hapus_rekomendasi.php?id=<?= $row['id_rekomendasi']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
<?php
include 'Config.php';

$data = mysqli_query($conn, "SELECT * FROM aktivitas_harian ORDER BY tanggal DESC");

$totalQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM aktivitas_harian");
$totalData = mysqli_fetch_assoc($totalQuery);
$totalAktivitas = $totalData['total'];

$rataQuery = mysqli_query($conn, "SELECT AVG(durasi_tidur) AS rata FROM aktivitas_harian");
$rataData = mysqli_fetch_assoc($rataQuery);
$rataTidur = round($rataData['rata'] ?? 0, 1);

$stresQuery = mysqli_query($conn, "SELECT tingkat_stres, COUNT(*) AS total 
                                  FROM aktivitas_harian 
                                  GROUP BY tingkat_stres 
                                  ORDER BY total DESC 
                                  LIMIT 1");
$stresData = mysqli_fetch_assoc($stresQuery);
$stresDominan = $stresData['tingkat_stres'] ?? '-';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Moodify - Aktivitas Harian</title>
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
    <h1>Mood Tracker 📊</h1>
    <p class="subtitle">Kelola aktivitas harian untuk memantau suasana hati pengguna</p>

    <div class="cards">
        <div class="card">
            <h3>Total Aktivitas</h3>
            <p><?= $totalAktivitas; ?></p>
        </div>

        <div class="card">
            <h3>Rata-rata Tidur</h3>
            <p><?= $rataTidur; ?> Jam</p>
        </div>

        <div class="card">
            <h3>Stres Dominan</h3>
            <p><?= $stresDominan; ?></p>
        </div>
    </div>

    <div class="box">
        <a href="admin_aktivitas.php" class="btn btn-menu">Aktivitas Harian</a>
        <a href="admin_rekomendasi.php" class="btn btn-menu">Rekomendasi Mood</a>

        <h2>Data Aktivitas Harian</h2>
        <a href="tambah_aktivitas.php" class="btn">+ Tambah Aktivitas</a>

        <table>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Durasi Tidur</th>
                <th>Aktivitas Fisik</th>
                <th>Tingkat Stres</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['tanggal']; ?></td>
                <td><?= $row['durasi_tidur']; ?> jam</td>
                <td><?= htmlspecialchars($row['aktivitas_fisik']); ?></td>
                <td><?= $row['tingkat_stres']; ?></td>
                <td><?= htmlspecialchars($row['catatan']); ?></td>
                <td>
                    <a class="btn-edit" href="edit_aktivitas.php?id=<?= $row['id_aktivitas']; ?>">Edit</a>
                    <a class="btn-delete" href="hapus_aktivitas.php?id=<?= $row['id_aktivitas']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
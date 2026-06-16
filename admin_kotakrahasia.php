<?php
session_start();
include 'config.php'; 

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}
if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])){
    $id_hapus = $_GET['id'];
    mysqli_query($conn, "DELETE FROM kotak_rahasia WHERE id_post = '$id_hapus'");
    header("Location: admin_kotakrahasia.php");
    exit();
}
$query_data = mysqli_query($conn, "SELECT * FROM kotak_rahasia ORDER BY id_post DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Forum - Moodify Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; }
        
        .navbar { background-color: #7f7f7f; padding: 15px 40px; display: flex; align-items: center; gap: 30px; }
        .navbar .brand { color: #ffd700; font-size: 24px; font-weight: bold; text-decoration: none; margin-right: 20px; }
        .navbar a.menu-link { color: white; text-decoration: none; font-weight: 500; font-size: 16px; padding: 5px 0; }
        .navbar a.active { border-bottom: 2px solid #ffd700; color: #ffd700; }
        .navbar .btn-logout { background-color: #ffd700; color: black; text-decoration: none; padding: 8px 20px; border-radius: 8px; font-weight: bold; margin-left: auto; font-size: 14px; }
        .navbar .btn-logout:hover { background-color: #e6c200; }

        .container { max-width: 1100px; margin: 40px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        h2 { color: #333; margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        table th { background-color: #7f7f7f; color: white; padding: 12px; text-align: left; }
        table td { padding: 12px; border-bottom: 1px solid #ddd; color: #444; }
        table tr:nth-child(even) { background-color: #fafafa; }
        
        .badge { background-color: #ffd700; color: black; padding: 5px 12px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .btn-delete { background-color: #e60000; color: white; text-decoration: none; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 500; }
        .btn-delete:hover { background-color: #b30000; }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="admin_dashboard.php" class="brand">Moodify Admin</a>
        <a href="admin_dashboard.php" class="menu-link">Dashboard</a>
        <a href="admin_kotakrahasia.php" class="menu-link active">Kelola Kotak Rahasia</a>
        <a href="admin_mydiary.php" class="menu-link">Monitoring Diary</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2>Moderasi Kotak Rahasia (Forum)</h2>
        <p style="color: #666;">Pantau dan hapus postingan cerita anonim yang tidak sesuai aturan.</p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Kategori</th>
                    <th>Isi Cerita Pengguna</th>
                    <th style="width: 12%; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($query_data)) { 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><span class="badge"><?php echo htmlspecialchars($row['kategori']); ?></span></td>
                    <td><?php echo htmlspecialchars($row['isi_cerita']); ?></td> 
                    <td style="text-align: center;">
                        <a href="admin_kotakrahasia.php?action=delete&id=<?php echo $row['id_post']; ?>" 
                           class="btn-delete" onclick="return confirm('Yakin ingin menghapus cerita ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
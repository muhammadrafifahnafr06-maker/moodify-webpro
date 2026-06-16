<?php
session_start();
include 'config.php'; 

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

$q_user  = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$q_admin = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
$q_forum = mysqli_query($conn, "SELECT COUNT(*) as total FROM kotak_rahasia");

$res_user  = mysqli_fetch_assoc($q_user);
$res_admin = mysqli_fetch_assoc($q_admin);
$res_forum = mysqli_fetch_assoc($q_forum);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Moodify</title>
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
        .grid-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px; }
        .card { padding: 25px; border-radius: 8px; color: white; text-align: center; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card-user { background-color: #4a90e2; }
        .card-admin { background-color: #20b2aa; }
        .card-forum { background-color: #7f7f7f; }
        .card h3 { margin: 0; font-size: 16px; font-weight: 500; opacity: 0.9; }
        .card p { font-size: 36px; font-weight: bold; margin: 15px 0 0 0; }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="admin_dashboard.php" class="brand">Moodify Admin</a>
        <a href="admin_dashboard.php" class="menu-link active">Dashboard</a>
        <a href="admin_kotakrahasia.php" class="menu-link">Kelola Kotak Rahasia</a>
        <a href="admin_kelolaakun.php" class="menu-link">Kelola Pengguna</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2>Selamat Datang, Admin</h2>
        <p style="color: #666;">Berikut adalah perkembangan total data fungsionalitas sistem Moodify saat ini:</p>
        
        <div class="grid-cards">
            <div class="card card-user">
                <h3>Total Pengguna Aktif</h3>
                <p><?php echo $res_user['total']; ?></p>
            </div>
            <div class="card card-admin">
                <h3>Total Admin Pengelola</h3>
                <p><?php echo $res_admin['total']; ?></p>
            </div>
            <div class="card card-forum">
                <h3>Total Postingan Forum</h3>
                <p><?php echo $res_forum['total']; ?></p>
            </div>
        </div>
    </div>

</body>
</html>
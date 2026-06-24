<?php
session_start();
include 'config.php'; 

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: login.php");
    exit();
}

if (isset($_POST['tambah_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];

    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_kelolaakun.php?status=success");
        exit();
    }
}

if (isset($_POST['edit_user'])) {
    $id = intval($_POST['id']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $query = "UPDATE users SET username='$username', email='$email', password='$password', role='$role' WHERE id_user=$id";
    } else {
        $query = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id_user=$id";
    }

    if (mysqli_query($conn, $query)) {
        header("Location: admin_kelolaakun.php?status=success");
        exit();
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $query = "DELETE FROM users WHERE id_user=$id";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_kelolaakun.php?status=success");
        exit();
    }
}

$query_data = mysqli_query($conn, "SELECT id_user, username, email, password, role FROM users ORDER BY id_user DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pengguna - Moodify Admin</title>
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
        
        .form-container { background: #fdfdfd; padding: 20px; border: 1px solid #ddd; border-radius: 6px; margin-bottom: 30px; }
        .form-container h3 { margin-top: 0; color: #444; }
        .form-grid { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; }
        .form-grid input, .form-grid select { padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
        .btn-submit { background-color: #ffd700; color: black; border: none; padding: 9px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn-submit:hover { background-color: #e6c200; }
        .btn-cancel { color: #666; text-decoration: none; margin-left: 10px; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        table th { background-color: #7f7f7f; color: white; padding: 12px; text-align: left; }
        table td { padding: 12px; border-bottom: 1px solid #ddd; color: #444; }
        table tr:nth-child(even) { background-color: #fafafa; }
        .btn-edit { color: #4a90e2; text-decoration: none; font-weight: bold; margin-right: 12px; }
        .btn-delete { color: #d9534f; text-decoration: none; font-weight: bold; cursor: pointer; display: inline-block; }
        .btn-delete:hover { color: #b30000; }

        .custom-modal {
            display: none; 
            position: fixed;
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%;
            background: rgba(0, 0, 0, 0.5); 
            justify-content: center; 
            align-items: center; 
            z-index: 9999; 
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 360px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            animation: fadeIn 0.25s ease;
        }

        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-modal-cancel {
            background-color: #e0e0e0;
            color: #333;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-modal-cancel:hover { background-color: #d5d5d5; }

        .btn-modal-confirm {
            background-color: #d9534f;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }
        .btn-modal-confirm:hover { background-color: #b30000; }

        @keyframes fadeIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="admin_dashboard.php" class="brand">Moodify Admin</a>
        <a href="admin_dashboard.php" class="menu-link">Dashboard</a>
        <a href="admin_kotakrahasia.php" class="menu-link">Kelola Kotak Rahasia</a>
        <a href="admin_kelolaakun.php" class="menu-link active">Kelola Pengguna</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <h2>Kelola Akun Pengguna</h2>
        <p style="color: #666;">Halaman manajemen data akun pengguna platform Moodify secara penuh.</p>

        <?php
        $edit_mode = false;
        $id_edit = $user_edit = $email_edit = $role_edit = '';
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $edit_mode = true;
            $id_edit = intval($_GET['id']);
            $search_user = mysqli_query($conn, "SELECT * FROM users WHERE id_user=$id_edit");
            if ($data_edit = mysqli_fetch_assoc($search_user)) {
                $user_edit = $data_edit['username'];
                $email_edit = $data_edit['email'];
                $role_edit = $data_edit['role'];
            }
        }
        ?>

        <div class="form-container">
            <h3><?php echo $edit_mode ? 'Ubah Data Pengguna' : 'Tambah Pengguna Baru'; ?></h3>
            <form action="admin_kelolaakun.php" method="POST" class="form-grid">
                <?php if($edit_mode): ?>
                    <input type="hidden" name="id" value="<?php echo $id_edit; ?>">
                <?php endif; ?>
                
                <input type="text" name="username" placeholder="Username" value="<?php echo $user_edit; ?>" required>
                <input type="email" name="email" placeholder="Email" value="<?php echo $email_edit; ?>">
                <input type="text" name="password" placeholder="<?php echo $edit_mode ? 'Kosongkan jika tidak diubah' : 'Password'; ?>" <?php echo $edit_mode ? '' : 'required'; ?>>
                
                <select name="role">
                    <option value="user" <?php echo $role_edit == 'user' ? 'selected' : ''; ?>>User / Anggota</option>
                    <option value="admin" <?php echo $role_edit == 'admin' ? 'selected' : ''; ?>>Admin / Pengelola</option>
                </select>

                <?php if($edit_mode): ?>
                    <button type="submit" name="edit_user" class="btn-submit">Simpan Perubahan</button>
                    <a href="admin_kelolaakun.php" class="btn-cancel">Batal</a>
                <?php else: ?>
                    <button type="submit" name="tambah_user" class="btn-submit">Tambah Akun</button>
                <?php endif; ?>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th style="width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($query_data)) { 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['username']); ?></strong></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['password']); ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="admin_kelolaakun.php?action=edit&id=<?php echo $row['id_user']; ?>" class="btn-edit">Edit</a>
                        
                        <a href="javascript:void(0);" class="btn-delete" 
                           onclick="openDeleteModal('admin_kelolaakun.php?action=delete&id=<?php echo $row['id_user']; ?>')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div id="deleteModal" class="custom-modal">
        <div class="modal-content">
            <h3 style="margin-top: 0; color: #333;">Konfirmasi Hapus</h3>
            <p style="color: #666;">Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="modal-buttons">
                <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Batal</button>
                <a id="confirmDeleteBtn" href="#" class="btn-modal-confirm" style="text-decoration: none; display: inline-block; line-height: 20px;">Hapus</a>
            </div>
        </div>
    </div>

    <script>
    function openDeleteModal(deleteUrl) {
        const modal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        
        confirmBtn.href = deleteUrl; 
        modal.style.display = 'flex'; 
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none'; 
    }

    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
    </script>

</body>
</html>
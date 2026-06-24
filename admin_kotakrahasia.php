<?php
session_start();
include 'config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

if (isset($_POST['submit_mood'])) {
    $mood = mysqli_real_escape_string($conn, $_POST['mood']);
    $motivasi = mysqli_real_escape_string($conn, $_POST['motivasi']);
    $tanggal = date('Y-m-d'); 

    $query = "INSERT INTO suasana_hati (id_user, mood, motivasi, tanggal) VALUES ('$user_id', '$mood', '$motivasi', '$tanggal')";
    
    if (mysqli_query($conn, $query)) {
        $message = "<div class='alert success'>Suasana hati berhasil disimpan!</div>";
    } else {
        $message = "<div class='alert error'>Gagal menyimpan: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Mood Tracker - Moodify</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 500px; margin: 40px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        h2 { color: #333; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        .btn-submit { background-color: #ffd700; color: black; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; }
        .btn-submit:hover { background-color: #e6c200; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; font-weight: bold; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="container">
    <h2>Bagaimana Suasana Hatimu Hari Ini?</h2>
    
    <?php echo $message; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="mood">Pilih Mood</label>
            <select name="mood" id="mood" required>
                <option value="">-- Pilih --</option>
                <option value="Tenang">Tenang</option>
                <option value="Gembira">Gembira</option>
                <option value="Sedih">Sedih</option>
                <option value="Cemas">Cemas</option>
            </select>
        </div>

        <div class="form-group">
            <label for="motivasi">Catatan / Motivasi Hari Ini</label>
            <textarea name="motivasi" id="motivasi" rows="4" placeholder="Apa yang membuatmu merasa demikian?" required></textarea>
        </div>

        <button type="submit" name="submit_mood" class="btn-submit">Simpan Suasana Hati</button>
    </form>
</div>

</body>
</html>
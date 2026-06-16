<?php
session_start();
include 'config.php';

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if(mysqli_num_rows($query) > 0){
        $data = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $data['id_user']; 
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role']; 

        if($_SESSION['role'] == 'admin'){
            header("Location: admin_dashboard.php");
            exit();
        } else {
            header("Location: kotakrahasia.php");
            exit();
        }

    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Moodify Login</title>
    <style>
        body { margin:0; font-family:Arial; background:#f5f5f5; display:flex; justify-content:center; align-items:center; height:100vh; flex-direction:column; }
        .login-box { background:white; padding:40px; width:350px; border-radius:20px; box-shadow:0px 5px 15px rgba(0,0,0,0.1); text-align:center; }
        h1 { color:#ffe600; font-size:40px; margin:0; }
        input { width:100%; padding:15px; margin:10px 0; border:none; border-radius:12px; background:#f1f1f1; box-sizing:border-box; }
        button { width:100%; padding:15px; border:none; border-radius:12px; background:#ffe600; font-weight:bold; cursor:pointer; margin-top:10px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Moodify</h1>
        <p>Silahkan Login</p>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button name="login">Login</button>
        </form>
    </div>
</body>
</html>
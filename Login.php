<?php
session_start();
include 'config.php'; 

if(isset($_POST['username']) && isset($_POST['password'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
    "SELECT * FROM users WHERE username='$username' AND password='$password'");

    $data = mysqli_fetch_array($query);

    if($data){
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];

        header("Location: suasana_hati.php");
        exit;
    }else{
        echo "Login gagal";
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
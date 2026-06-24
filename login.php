<?php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        header("Location: suasana_hati.php");
        exit();
    }
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        if ($password == $row['password']) {
         
            $_SESSION['user_id']  = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role']; 

     
            if ($row['role'] == 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: suasana_hati.php");
                exit();
            }

        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='login.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Moodify Login</title>

    <style>
        body { 
            margin: 0; 
            font-family: system-ui, -apple-system, sans-serif; 
            background: #f5f5f5; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            flex-direction: column; 
        }

        .login-box { 
            background: white; 
            padding: 40px; 
            width: 350px; 
            border-radius: 20px; 
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1); 
            text-align: center; 
        }

        h1 { 
            color: #ffe600; 
            font-size: 40px; 
            margin: 0; 
            font-weight: 800;
        }

        p {
            margin-bottom: 25px;
            color: #333;
            font-weight: 500;
        }

        input { 
            width: 100%; 
            padding: 15px; 
            margin: 10px 0; 
            border: none; 
            border-radius: 12px; 
            background: #f1f1f1; 
            box-sizing: border-box; 
            outline: none;
            font-family: system-ui, sans-serif;
        }

        input:focus {
            border: 1px solid #333;
            background: #ffffff;
        }

        button { 
            width: 100%; 
            padding: 15px; 
            border: none; 
            border-radius: 12px; 
            background: #ffe600; 
            font-weight: bold; 
            cursor: pointer; 
            margin-top: 10px; 
            font-family: system-ui, sans-serif;
            font-size: 15px;
        }

        button:hover {
            background: #f4d600;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <h1>Moodify</h1>
        <p>Silahkan Login</p>

        <form action="" method="POST">
            <input 
                type="text" 
                name="username" 
                placeholder="Username" 
                required
            >

            <input 
                type="password" 
                name="password" 
                placeholder="Password" 
                required
            >

            <button type="submit" name="login">
                Login
            </button>
        </form>
    </div>

</body>
</html>
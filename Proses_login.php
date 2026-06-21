<?php
session_start();

include 'Config.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE username='$username'
        AND password='$password'"
    );

    $data = mysqli_fetch_assoc($query);

    if ($data) {

        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['user_id'] = $data['id_user']; 

        header("Location: suasana_hati.php");
        exit();

    } else {
        echo "<script>
                alert('Username atau password salah!');
                window.location='login.php';
              </script>";

    }

} else {

    header("Location: login.php");
    exit();

}
?>
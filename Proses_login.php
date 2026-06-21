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
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        header("Location: suasana_hati.php");
        exit();

    } else {

        echo "<script>
                alert('Username atau password salah!');
                window.location='Login.php';
              </script>";

    }

} else {

    header("Location: Login.php");
    exit();

}
?>
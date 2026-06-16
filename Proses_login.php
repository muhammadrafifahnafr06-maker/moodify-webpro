<?php
session_start();

include 'Config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users
    WHERE username='$username'
    AND password='$password'"
);

$data = mysqli_num_rows($query);

if($data > 0){

    $_SESSION['login'] = true;

    header("Location: suasana_hati.php");

}else{

    echo "Login gagal";

}

?> 
<?php
session_start();
include "config.php";

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

if(!isset($_POST['mood'])){
    header("Location: suasana_hati.php");
    exit;
}

$id_user=$_SESSION['id_user'];

$mood=mysqli_real_escape_string($conn,$_POST['mood']);

$tanggal=date("Y-m-d");

switch($mood){

case "Gembira":
$motivasi="Pertahankan senyum itu! Energi positifmu hari ini luar biasa ✨";
break;

case "Tenang":
$motivasi="Nikmati ketenanganmu. Hari ini adalah kesempatan untuk tumbuh dengan damai 🤍";
break;

case "Sedih":
$motivasi="Tidak apa-apa merasa sedih. Besok masih ada harapan baru 🌸";
break;

case "Lelah":
$motivasi="Kamu sudah berusaha keras. Jangan lupa beri waktu untuk beristirahat ☁️";
break;

case "Marah":
$motivasi="Tarik napas perlahan. Semua masalah pasti ada jalan keluarnya ❤️";
break;

case "Semangat":
$motivasi="Semangatmu hari ini luar biasa! Terus melangkah menuju impianmu ⭐";
break;

default:
$motivasi="Semoga harimu menyenangkan.";

}

mysqli_query(

$conn,

"INSERT INTO suasana_hati
(id_user,mood,motivasi,tanggal)
VALUES
('$id_user','$mood','$motivasi','$tanggal')"

);

header("Location: suasana_hati.php");
exit;

?>
<?php
session_start();
include "config.php";

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id_user=$_SESSION['id_user'];

$id=isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result=mysqli_query(
$conn,
"SELECT * FROM suasana_hati
WHERE id_mood='$id'
AND id_user='$id_user'"
);

$data=mysqli_fetch_assoc($result);

if(!$data){
    header("Location: suasana_hati.php");
    exit;
}

if(isset($_POST['update'])){

    $mood=mysqli_real_escape_string($conn,$_POST['mood']);

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
    "UPDATE suasana_hati
    SET
    mood='$mood',
    motivasi='$motivasi'
    WHERE
    id_mood='$id'
    AND
    id_user='$id_user'"
    );

    header("Location: suasana_hati.php");
    exit;

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Suasana Hati</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
background:#f5f5f5;
}

.container{
width:90%;
margin:40px auto;
}

.card{
background:white;
padding:30px;
border-radius:20px;
}

h2{
color:#f4d600;
margin-bottom:25px;
}

.box{
display:flex;
flex-wrap:wrap;
gap:20px;
}

label{
cursor:pointer;
}

input[type=radio]{
display:none;
}

.item{

width:180px;
height:150px;
border-radius:20px;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
transition:.3s;

}

.item:hover{
transform:scale(1.05);
}

input[type=radio]:checked + .item{
border:4px solid #333;
}

.gembira{
background:#FCE8D5;
}

.tenang{
background:#DDF6EA;
}

.sedih{
background:#E7E5FA;
}

.lelah{
background:#F4E0D8;
}

.marah{
background:#F8E3E5;
}

.semangat{
background:#F9F1BE;
}

.icon{
font-size:45px;
}

.nama{
margin-top:10px;
font-size:20px;
font-weight:bold;
}

button{

margin-top:30px;
padding:12px 22px;
background:#f4d600;
border:none;
border-radius:10px;
font-weight:bold;
cursor:pointer;

}

a{

margin-left:15px;
text-decoration:none;
font-weight:bold;
color:#555;

}

</style>

</head>

<body>

<div class="container">

<div class="card">

<h2>Edit Suasana Hati</h2>

<form method="POST">

<div class="box">

<label>

<input
type="radio"
name="mood"
value="Gembira"
<?php if($data['mood']=="Gembira") echo "checked"; ?>>

<div class="item gembira">

<div class="icon">😊</div>

<div class="nama">Gembira</div>

</div>

</label>

<label>

<input
type="radio"
name="mood"
value="Tenang"
<?php if($data['mood']=="Tenang") echo "checked"; ?>>

<div class="item tenang">

<div class="icon">💚</div>

<div class="nama">Tenang</div>

</div>

</label>

<label>

<input
type="radio"
name="mood"
value="Sedih"
<?php if($data['mood']=="Sedih") echo "checked"; ?>>

<div class="item sedih">

<div class="icon">😢</div>

<div class="nama">Sedih</div>

</div>

</label>

<label>

<input
type="radio"
name="mood"
value="Lelah"
<?php if($data['mood']=="Lelah") echo "checked"; ?>>

<div class="item lelah">

<div class="icon">😴</div>

<div class="nama">Lelah</div>

</div>

</label>

<label>

<input
type="radio"
name="mood"
value="Marah"
<?php if($data['mood']=="Marah") echo "checked"; ?>>

<div class="item marah">

<div class="icon">😡</div>

<div class="nama">Marah</div>

</div>

</label>

<label>

<input
type="radio"
name="mood"
value="Semangat"
<?php if($data['mood']=="Semangat") echo "checked"; ?>>

<div class="item semangat">

<div class="icon">⭐</div>

<div class="nama">Semangat</div>

</div>

</label>

</div>

<button type="submit" name="update">
Simpan Perubahan
</button>

<a href="suasana_hati.php">
Kembali
</a>

</form>

</div>

</div>

</body>
</html>
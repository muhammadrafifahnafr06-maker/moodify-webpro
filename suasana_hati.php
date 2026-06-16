<?php
session_start();
include "config.php";

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id_user=$_SESSION['id_user'];

$data=mysqli_query(
$conn,
"SELECT * FROM suasana_hati
WHERE id_user='$id_user'
ORDER BY id_mood DESC"
);

$username="User";

if(isset($_SESSION['username'])){
    $username=$_SESSION['username'];
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Suasana Hati</title>

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

.navbar{

background: #737373;
padding:18px 40px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 2px 8px rgba(0,0,0,.08);

}

.logo{

font-size:34px;
font-weight:bold;
color:#f4d600;

}

.menu a{

text-decoration:none;
margin-left:25px;
font-weight:bold;
color:#ffffff;

}

.menu a:hover{

color:#f4d600;

}

.container{

width:90%;
margin:35px auto;

}

.card{

background:white;
padding:30px;
border-radius:20px;
margin-bottom:25px;

}

h1{

color:#333;
margin-bottom:10px;

}

.subtitle{

color:#777;
margin-bottom:30px;

}

.box{

display:flex;
flex-wrap:wrap;
gap:20px;

}

form{

margin:0;

}

button{

border:none;
cursor:pointer;

}

.mood{

width:180px;
height:150px;
border-radius:20px;
display:flex;
flex-direction:column;
justify-content:center;
align-items:center;
transition:.3s;

}

.mood:hover{

transform:scale(1.05);

}

.icon{

font-size:48px;

}

.nama{

margin-top:10px;
font-size:20px;
font-weight:bold;

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

table{

width:100%;
border-collapse:collapse;
margin-top:20px;

}

th{

background:#f4d600;
padding:12px;

}

td{

padding:12px;
text-align:center;
border-bottom:1px solid #ddd;

}

.edit{

color:blue;
text-decoration:none;
font-weight:bold;

}

.hapus{

color:red;
text-decoration:none;
font-weight:bold;

}

</style>

</head>

<body>

<div class="navbar">

<div class="logo">

Moodify

</div>

<div class="menu">

<a href="suasana_hati.php">Suasana Hati</a>

<a href="mydiary.php">My Diary</a>

<a href="kotak_rahasia.php">Kotak Rahasia</a>

<a href="mood_tracker.php">Mood Tracker</a>

<a href="logout.php">Logout</a>

</div>

</div>

<div class="container">

<div class="card">

<h1>

Halo, <?php echo $username; ?> 👋

</h1>

<div class="subtitle">

Apa yang kamu rasakan hari ini?

</div>

<div class="box">

<form action="simpan_mood.php" method="POST">

<input type="hidden" name="mood" value="Gembira">

<button class="mood gembira">

<div class="icon">😊</div>

<div class="nama">Gembira</div>

</button>

</form>

<form action="simpan_mood.php" method="POST">

<input type="hidden" name="mood" value="Tenang">

<button class="mood tenang">

<div class="icon">💚</div>

<div class="nama">Tenang</div>

</button>

</form>

<form action="simpan_mood.php" method="POST">

<input type="hidden" name="mood" value="Sedih">

<button class="mood sedih">

<div class="icon">😢</div>

<div class="nama">Sedih</div>

</button>

</form>

<form action="simpan_mood.php" method="POST">

<input type="hidden" name="mood" value="Lelah">

<button class="mood lelah">

<div class="icon">😴</div>

<div class="nama">Lelah</div>

</button>

</form>

<form action="simpan_mood.php" method="POST">

<input type="hidden" name="mood" value="Marah">

<button class="mood marah">

<div class="icon">😡</div>

<div class="nama">Marah</div>

</button>

</form>

<form action="simpan_mood.php" method="POST">

<input type="hidden" name="mood" value="Semangat">

<button class="mood semangat">

<div class="icon">⭐</div>

<div class="nama">Semangat</div>

</button>

</form>

</div>

</div>

<div class="card">

<h2 style="color:#f4d600;">

Riwayat Mood

</h2>

<table>

<tr>

<th>No</th>

<th>Mood</th>

<th>Motivasi</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

<?php

$no=1;

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td><?php echo $no++; ?></td>

<td><?php echo $d['mood']; ?></td>

<td><?php echo $d['motivasi']; ?></td>

<td><?php echo $d['tanggal']; ?></td>

<td>

<a class="edit" href="edit_mood.php?id=<?php echo $d['id_mood']; ?>">

Edit

</a>

|

<a class="hapus"

href="hapus_mood.php?id=<?php echo $d['id_mood']; ?>"

onclick="return confirm('Yakin ingin menghapus?')">

Hapus

</a>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</body>
</html>
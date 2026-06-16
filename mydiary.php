<?php
session_start();
include 'config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id_user=$_SESSION['id_user'];

$search="";

if(isset($_GET['search'])){

    $search=mysqli_real_escape_string($conn,$_GET['search']);

    $data=mysqli_query(
    $conn,
    "SELECT * FROM my_diary
    WHERE id_user='$id_user'
    AND(
    judul LIKE '%$search%'
    OR
    isi_diary LIKE '%$search%'
    )
    ORDER BY id_diary DESC"
    );

}
else{

    $data=mysqli_query(
    $conn,
    "SELECT * FROM my_diary
    WHERE id_user='$id_user'
    ORDER BY id_diary DESC"
    );

}
?>

<!DOCTYPE html>
<html>

<head>

<title>My Diary</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
background:#F7F7F7;
}

.navbar{

background:#737373;
padding:18px 45px;

display:flex;
justify-content:space-between;
align-items:center;

box-shadow:0 3px 10px rgba(0,0,0,.08);

position:sticky;
top:0;

}

.logo{

color:#FFD600;
font-size:36px;
font-weight:bold;

}

.menu a{

text-decoration:none;
color:#ffffff;
margin-left:28px;
font-weight:bold;
transition:.3s;

}

.menu a:hover{

color:#FFD600;

}

.container{

width:92%;
max-width:1200px;
margin:35px auto;

}

.card{

background:white;
padding:28px;
border-radius:22px;
margin-bottom:25px;
box-shadow:0 4px 12px rgba(0,0,0,.06);

}

h2{

color:#E8B400;
margin-bottom:10px;
font-size:28px;

}

input{

width:100%;
padding:14px;
border-radius:12px;
border:1px solid #ddd;
font-size:15px;

}

textarea{

width:100%;
padding:14px;
border-radius:12px;
border:1px solid #ddd;
height:150px;
font-size:15px;

}

button{

padding:13px 24px;
background:#FFD600;
color:#444;
font-weight:bold;
border:none;
border-radius:12px;
cursor:pointer;
transition:.3s;

}

button:hover{

transform:scale(1.03);

}

table{

width:100%;
border-collapse:collapse;
margin-top:20px;
overflow:hidden;
border-radius:15px;

}

th{

background:#FFD600;
color:#444;
padding:14px;

}

td{

padding:14px;
text-align:center;
background:white;
border-bottom:1px solid #eee;

}

.action{

text-decoration:none;
font-weight:bold;

}

.edit{

color:#2D8CFF;
font-weight:bold;

}

.hapus{

color:#E53935;
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

<a href="mydiary.php">
My Diary
</a>

<a href="kotak_rahasia.php">
Kotak Rahasia
</a>

<a href="mood_tracker.php">
Mood Tracker
</a>

<a href="logout.php">
Logout
</a>

</div>

</div>

<div class="container">

<div class="card">

<h2>

My Diary

</h2>

<p>

Tuliskan cerita hari ini 🌱

</p>

</div>

<div class="card">

<form method="GET">

<input
type="text"
name="search"
value="<?php echo $search;?>"
placeholder="Cari diary...">

<br><br>

<button>

Cari

</button>

</form>

</div>

<div class="card">

<h2>

Tambah Diary

</h2>

<form
action="tambah.php"
method="POST">

<input
type="text"
name="judul"
placeholder="Judul"
required>

<br><br>

<textarea
name="isi"
placeholder="Isi Diary"
required></textarea>

<br><br>

<button
type="submit">

Simpan

</button>

</form>

</div>

<div class="card">

<h2>

List Diary

</h2>

<table>

<tr>

<th>No</th>

<th>Judul</th>

<th>Isi</th>

<th>Tanggal</th>

<th>Aksi</th>

</tr>

<?php

$no=1;

while($d=mysqli_fetch_assoc($data)){

?>

<tr>

<td>

<?php echo $no++;?>

</td>

<td>

<?php echo $d['judul'];?>

</td>

<td>

<?php echo $d['isi_diary'];?>

</td>

<td>

<?php echo $d['tanggal'];?>

</td>

<td>

<a
class="action edit"
href="edit.php?id=<?php echo $d['id_diary'];?>">

Edit

</a>

|

<a
class="action hapus"
href="hapus.php?id=<?php echo $d['id_diary'];?>"
onclick="return confirm('Yakin ingin menghapus diary ini?')">

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

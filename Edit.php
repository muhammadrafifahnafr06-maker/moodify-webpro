<?php
session_start();
include 'config.php';

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = mysqli_query(
$conn,
"SELECT * FROM my_diary
WHERE id_diary='$id'
AND id_user='$id_user'"
);

$data = mysqli_fetch_assoc($result);

if(!$data){
    header("Location: mydiary.php");
    exit;
}

if(isset($_POST['update'])){

    $judul = mysqli_real_escape_string($conn,$_POST['judul']);
    $isi = mysqli_real_escape_string($conn,$_POST['isi']);

    mysqli_query(
    $conn,
    "UPDATE my_diary
    SET
    judul='$judul',
    isi_diary='$isi'
    WHERE
    id_diary='$id'
    AND
    id_user='$id_user'"
    );

    header("Location: mydiary.php");
    exit;

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Diary</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
}

.container{
width:700px;
margin:40px auto;
background:white;
padding:30px;
border-radius:15px;
}

h2{
color:#F4B000;
}

input,textarea{

width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:8px;

}

textarea{

height:180px;

}

button{

margin-top:20px;
padding:12px 20px;
background:#F4B000;
color:white;
border:none;
border-radius:8px;
cursor:pointer;

}

a{

text-decoration:none;
margin-left:15px;
font-weight:bold;
color:#555;

}

</style>

</head>

<body>

<div class="container">

<h2>Edit Diary</h2>

<form method="POST">

<input
type="text"
name="judul"
value="<?php echo htmlspecialchars($data['judul']); ?>"
required>

<br><br>

<textarea
name="isi"
required><?php echo htmlspecialchars($data['isi_diary']); ?></textarea>

<br>

<button
type="submit"
name="update">

Simpan Perubahan

</button>

<a href="mydiary.php">

Kembali

</a>

</form>

</div>

</body>
</html>

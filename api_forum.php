<?php
session_start();
header("Content-Type: application/json");
include 'config.php';
error_reporting(0);

$method = $_SERVER['REQUEST_METHOD'];

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Kamu belum login!"]);
    exit;
}

$id_user = $_SESSION['user_id'];

if ($method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $kategori = mysqli_real_escape_string($conn, $input['kategori']);
    $isi = mysqli_real_escape_string($conn, $input['isi_cerita']);
    
    $sql = "INSERT INTO kotak_rahasia (id_user, kategori, isi_cerita) VALUES ('$id_user', '$kategori', '$isi')";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Cerita berhasil dikirim"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

else if ($method === 'PUT') {
    $input = json_decode(file_get_contents("php://input"), true);
    $id_post = mysqli_real_escape_string($conn, $input['id_post']);
    $isi_baru = mysqli_real_escape_string($conn, $input['isi_cerita']);
    
    $sql = "UPDATE kotak_rahasia SET isi_cerita='$isi_baru' WHERE id_post='$id_post' AND id_user='$id_user'";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Cerita berhasil diperbarui"]);
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}

else if ($method === 'DELETE') {
    $id_post = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "DELETE FROM kotak_rahasia WHERE id_post='$id_post' AND id_user='$id_user'";
    
    if (mysqli_query($conn, $sql)) {
        if (mysqli_affected_rows($conn) > 0) {
            echo json_encode(["status" => "success", "message" => "Cerita berhasil dihapus"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Gagal: Data tidak ditemukan atau bukan milikmu"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
}
?>
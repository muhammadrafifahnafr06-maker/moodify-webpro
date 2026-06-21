<?php
include 'Config.php';

header("Content-Type: application/json");

$valid_api_key = "moodify123";

$headers = function_exists('getallheaders') ? getallheaders() : [];
$header_key = $headers['X-API-KEY'] ?? $headers['x-api-key'] ?? '';
$query_key = $_GET['api_key'] ?? '';

if ($header_key !== $valid_api_key && $query_key !== $valid_api_key) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "API Key tidak valid"
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    $result = mysqli_query($conn, "SELECT * FROM rekomendasi_mood ORDER BY id_rekomendasi DESC");
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode([
        "status" => true,
        "message" => "Data rekomendasi berhasil diambil",
        "data" => $data
    ]);
}

elseif ($method == "POST") {
    $mood_target = $_POST['mood_target'] ?? '';
    $judul = $_POST['judul'] ?? '';
    $kategori = $_POST['kategori'] ?? '';
    $isi_rekomendasi = $_POST['isi_rekomendasi'] ?? '';

    $query = "INSERT INTO rekomendasi_mood 
              (mood_target, judul, kategori, isi_rekomendasi)
              VALUES 
              ('$mood_target', '$judul', '$kategori', '$isi_rekomendasi')";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => true,
            "message" => "Data rekomendasi berhasil ditambahkan"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Data rekomendasi gagal ditambahkan"
        ]);
    }
}

elseif ($method == "PUT") {
    parse_str(file_get_contents("php://input"), $put);

    $id = $put['id_rekomendasi'] ?? '';
    $mood_target = $put['mood_target'] ?? '';
    $judul = $put['judul'] ?? '';
    $kategori = $put['kategori'] ?? '';
    $isi_rekomendasi = $put['isi_rekomendasi'] ?? '';

    $query = "UPDATE rekomendasi_mood SET
              mood_target = '$mood_target',
              judul = '$judul',
              kategori = '$kategori',
              isi_rekomendasi = '$isi_rekomendasi'
              WHERE id_rekomendasi = '$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => true,
            "message" => "Data rekomendasi berhasil diperbarui"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Data rekomendasi gagal diperbarui"
        ]);
    }
}

elseif ($method == "DELETE") {
    parse_str(file_get_contents("php://input"), $delete);

    $id = $delete['id_rekomendasi'] ?? '';

    $query = "DELETE FROM rekomendasi_mood WHERE id_rekomendasi = '$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => true,
            "message" => "Data rekomendasi berhasil dihapus"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Data rekomendasi gagal dihapus"
        ]);
    }
}

else {
    http_response_code(405);
    echo json_encode([
        "status" => false,
        "message" => "Method tidak diizinkan"
    ]);
}
?>
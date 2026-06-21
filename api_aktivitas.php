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
    $result = mysqli_query($conn, "SELECT * FROM aktivitas_harian ORDER BY tanggal DESC");
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode([
        "status" => true,
        "message" => "Data aktivitas berhasil diambil",
        "data" => $data
    ]);
}

elseif ($method == "POST") {
    $tanggal = $_POST['tanggal'] ?? '';
    $durasi_tidur = $_POST['durasi_tidur'] ?? '';
    $aktivitas_fisik = $_POST['aktivitas_fisik'] ?? '';
    $tingkat_stres = $_POST['tingkat_stres'] ?? '';
    $catatan = $_POST['catatan'] ?? '';

    $query = "INSERT INTO aktivitas_harian 
              (tanggal, durasi_tidur, aktivitas_fisik, tingkat_stres, catatan)
              VALUES 
              ('$tanggal', '$durasi_tidur', '$aktivitas_fisik', '$tingkat_stres', '$catatan')";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => true,
            "message" => "Data aktivitas berhasil ditambahkan"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Data aktivitas gagal ditambahkan"
        ]);
    }
}

elseif ($method == "PUT") {
    parse_str(file_get_contents("php://input"), $put);

    $id = $put['id_aktivitas'] ?? '';
    $tanggal = $put['tanggal'] ?? '';
    $durasi_tidur = $put['durasi_tidur'] ?? '';
    $aktivitas_fisik = $put['aktivitas_fisik'] ?? '';
    $tingkat_stres = $put['tingkat_stres'] ?? '';
    $catatan = $put['catatan'] ?? '';

    $query = "UPDATE aktivitas_harian SET
              tanggal = '$tanggal',
              durasi_tidur = '$durasi_tidur',
              aktivitas_fisik = '$aktivitas_fisik',
              tingkat_stres = '$tingkat_stres',
              catatan = '$catatan'
              WHERE id_aktivitas = '$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => true,
            "message" => "Data aktivitas berhasil diperbarui"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Data aktivitas gagal diperbarui"
        ]);
    }
}

elseif ($method == "DELETE") {
    parse_str(file_get_contents("php://input"), $delete);

    $id = $delete['id_aktivitas'] ?? '';

    $query = "DELETE FROM aktivitas_harian WHERE id_aktivitas = '$id'";

    if (mysqli_query($conn, $query)) {
        echo json_encode([
            "status" => true,
            "message" => "Data aktivitas berhasil dihapus"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Data aktivitas gagal dihapus"
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

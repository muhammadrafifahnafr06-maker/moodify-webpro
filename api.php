<?php

include 'config.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
 
$fitur = isset($_GET['fitur']) ? $_GET['fitur'] : '';

if($method=="GET"){

    if($fitur=="mood"){

        $query=mysqli_query(
        $conn,
        "SELECT * FROM suasana_hati ORDER BY id_mood DESC"
        );

        $data=[];

        while($row=mysqli_fetch_assoc($query)){
            $data[]=$row;
        }

        echo json_encode([
            "status"=>"success",
            "data"=>$data
        ]);

    }

    elseif($fitur=="diary"){

        $query=mysqli_query(
        $conn,
        "SELECT * FROM my_diary ORDER BY id_diary DESC"
        );

        $data=[];

        while($row=mysqli_fetch_assoc($query)){
            $data[]=$row;
        }

        echo json_encode([
            "status"=>"success",
            "data"=>$data
        ]);

    }

    else{

        echo json_encode([
            "status"=>"failed",
            "message"=>"Parameter fitur tidak ditemukan"
        ]);

    }

}

elseif($method=="POST"){

    if($fitur=="mood"){

        $id_user=$_POST['id_user'];
        $mood=$_POST['mood'];
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

        $query=mysqli_query(
        $conn,
        "INSERT INTO suasana_hati
        (id_user,mood,motivasi,tanggal)
        VALUES
        ('$id_user','$mood','$motivasi','$tanggal')"
        );

        if($query){

            echo json_encode([
                "status"=>"success",
                "message"=>"Mood berhasil disimpan"
            ]);

        }else{

            echo json_encode([
                "status"=>"failed",
                "message"=>"Mood gagal disimpan"
            ]);

        }

    }

    elseif($fitur=="diary"){

        $id_user=$_POST['id_user'];
        $judul=$_POST['judul'];
        $isi=$_POST['isi'];
        $tanggal=date("Y-m-d");

        $query=mysqli_query(
        $conn,
        "INSERT INTO my_diary
        (id_user,judul,isi_diary,tanggal)
        VALUES
        ('$id_user','$judul','$isi','$tanggal')"
        );

        if($query){

            echo json_encode([
                "status"=>"success",
                "message"=>"Diary berhasil ditambahkan"
            ]);

        }else{

            echo json_encode([
                "status"=>"failed",
                "message"=>"Diary gagal ditambahkan"
            ]);

        }

    }

    else{

        echo json_encode([
            "status"=>"failed",
            "message"=>"Parameter fitur tidak ditemukan"
        ]);

    }

}

else{

    echo json_encode([
        "status"=>"failed",
        "message"=>"Method tidak didukung"
    ]);

}

?>

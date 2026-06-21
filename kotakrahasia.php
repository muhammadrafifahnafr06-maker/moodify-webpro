<?php
session_start();
include 'Config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$filter = "";

if(isset($_GET['forum']) && $_GET['forum'] != ""){
    $forum = mysqli_real_escape_string($conn, $_GET['forum']);
    $filter = "WHERE kategori='$forum'";
}

$query_data = mysqli_query($conn, "SELECT * FROM kotak_rahasia $filter ORDER BY id_post DESC");
?>

<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Moodify - Kotak Rahasia</title>
   <link rel="stylesheet" href="style_forum.css?v=3">
</head>
<body>

<div id="notif"></div>

<div class="navbar">
    <div class="logo">Moodify</div>
    <div class="menu">
        <a href="suasana_hati.php">Suasana Hati</a>
        <a href="mydiary.php">My Diary</a>
        <a href="kotakrahasia.php" class="active">Kotak Rahasia</a> <a href="mood_tracker.php">Mood Tracker</a>
        <a href="logout.php">Logout</a> </div>
</div>

<div class="container">
    <h1>Kotak Rahasia</h1>
    <p style="color: #666; margin-top: -10px; margin-bottom: 30px;">Bercerita secara anonim</p>

<select id="kategori">
    <option value="Anxiety">Anxiety</option>
    <option value="Depresi">Depresi</option>
    <option value="Stres">Stres</option>
</select>

<textarea id="isi_cerita" placeholder="Tulis ceritamu di sini..."></textarea>

<button class="kirim-btn" onclick="kirimCerita()">Kirim Cerita</button>

<hr style="margin:40px 0; border: 0; border-top: 1px solid #eee;">

<form method="GET" style="display: flex; gap: 10px; margin-bottom: 30px;">
    <select name="forum" style="margin-bottom: 0;">
        <option value="">Semua Forum</option>
        <option value="Anxiety" <?php if(isset($_GET['forum']) && $_GET['forum']=='Anxiety') echo 'selected'; ?>>Anxiety</option>
        <option value="Depresi" <?php if(isset($_GET['forum']) && $_GET['forum']=='Depresi') echo 'selected'; ?>>Depresi</option>
        <option value="Stres" <?php if(isset($_GET['forum']) && $_GET['forum']=='Stres') echo 'selected'; ?>>Stres</option>
    </select>
    <button type="submit" class="kirim-btn" style="white-space: nowrap;">Filter Forum</button>
</form>

<h2>Daftar Cerita</h2>

<?php while($row = mysqli_fetch_assoc($query_data)): ?>
<div class="card" id="post-<?php echo $row['id_post']; ?>">
    <span class="badge"><?php echo htmlspecialchars($row['kategori']); ?></span>
    <p id="text-<?php echo $row['id_post']; ?>" style="line-height: 1.6; margin: 15px 0;">
        <?php echo nl2br(htmlspecialchars($row['isi_cerita'])); ?>
    </p>

    <div style="margin-top:15px;">
        <button onclick="bukaModalEdit(<?php echo $row['id_post']; ?>)"
                style="cursor:pointer; background:#4CAF50; color:white; border:none; padding:6px 15px; border-radius:20px; font-size:13px;">
            Edit
        </button>

        <button onclick="bukaModalHapus(<?php echo $row['id_post']; ?>)"
                style="cursor:pointer; background:#ff4757; color:white; border:none; padding:6px 15px; border-radius:20px; font-size:13px; margin-left: 5px;">
            Hapus
        </button>
    </div>
</div>
<?php endwhile; ?>

</div>

<div id="modalHapus" class="custom-modal">
    <div class="modal-content">
        <h3>Konfirmasi Hapus</h3>
        <p>Yakin ingin menghapus cerita ini secara permanen?</p>
        <div class="modal-buttons">
            <button class="btn-cancel" onclick="tutupModal('modalHapus')">Batal</button>
            <button id="btnKonfirmasiHapus" class="btn-confirm">Hapus</button>
        </div>
    </div>
</div>

<div id="modalEdit" class="custom-modal">
    <div class="modal-content">
        <h3>Edit Ceritamu</h3>
        <textarea id="inputEditCerita" style="border: 1px solid #ccc; margin-top:10px;"></textarea>
        <div class="modal-buttons">
            <button class="btn-cancel" onclick="tutupModal('modalEdit')">Batal</button>
            <button id="btnKonfirmasiEdit" class="btn-save">Simpan Perubahan</button>
        </div>
    </div>
</div>

<script>
let idPostTerpilih = null;

function tampilNotif(pesan, tipe){
    const notif = document.getElementById("notif");
    notif.innerHTML = `<div class="${tipe}">${pesan}</div>`;
    setTimeout(() => { notif.innerHTML = ""; }, 3000);
}

function tutupModal(idModal) {
    document.getElementById(idModal).style.display = "none";
}

function bukaModalHapus(id) {
    idPostTerpilih = id;
    document.getElementById("modalHapus").style.display = "flex";
}

document.getElementById("btnKonfirmasiHapus").addEventListener("click", async () => {
    tutupModal("modalHapus");
    if(!idPostTerpilih) return;

    try {
        const response = await fetch(`api_forum.php?id=${idPostTerpilih}`, { method: "DELETE" });
        const hasil = await response.json();

        if(hasil.status === "success"){
            tampilNotif("Cerita berhasil dihapus!", "notif-sukses");
            setTimeout(() => { location.reload(); }, 1000);
        } else {
            tampilNotif(hasil.message, "notif-gagal");
        }
    } catch(error) {
        tampilNotif("Gagal menghapus cerita", "notif-gagal");
    }
});

function bukaModalEdit(id) {
    idPostTerpilih = id;
    const textLama = document.getElementById(`text-${id}`).innerText;
    document.getElementById("inputEditCerita").value = textLama;
    document.getElementById("modalEdit").style.display = "flex";
}

document.getElementById("btnKonfirmasiEdit").addEventListener("click", async () => {
    const isiBaru = document.getElementById("inputEditCerita").value;
    const textLama = document.getElementById(`text-${idPostTerpilih}`).innerText;
    tutupModal("modalEdit");

    if (isiBaru.trim() === "" || isiBaru === textLama) {
        return;
    }

    try {
        const response = await fetch("api_forum.php", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id_post: idPostTerpilih, isi_cerita: isiBaru })
        });
        const hasil = await response.json();

        if(hasil.status === "success"){
            tampilNotif("Cerita berhasil diperbarui!", "notif-sukses");
            setTimeout(() => { location.reload(); }, 1000);
        } else {
            tampilNotif(hasil.message, "notif-gagal");
        }
    } catch(error) {
        tampilNotif("Gagal mengedit cerita", "notif-gagal");
    }
});

async function kirimCerita(){
    const kategori = document.getElementById("kategori").value;
    const isi_cerita = document.getElementById("isi_cerita").value;

    if(!isi_cerita.trim()){
        tampilNotif("Jangan dikosongkan ya!", "notif-gagal");
        return;
    }

    try {
        const response = await fetch("api_forum.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ aksi: "tambah", kategori: kategori, isi_cerita: isi_cerita })
        });

        const hasil = await response.json();
        if(hasil.status === "success"){
            tampilNotif("Cerita berhasil dikirim!", "notif-sukses");
            setTimeout(() => { location.reload(); }, 1000);
        } else {
            tampilNotif(hasil.message, "notif-gagal");
        }
    } catch(error){
        tampilNotif("Terjadi kesalahan sistem saat mengirim!", "notif-gagal");
    }
}
</script>

</body>
</html>
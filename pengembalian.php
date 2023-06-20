<?php
session_start();
require_once "koneksi_mysql.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

// Daftar barang yang dipinjam oleh pengguna
$sql = "SELECT * FROM lenovo WHERE peminjam = '$username'";
$result = mysqli_query($server, $sql);
$barangDipinjam = [];
while ($row = mysqli_fetch_assoc($result)) {
    $barangDipinjam[$row['kode_barang']] = [
        'nama_barang' => $row['nama_barang'],
        'status' => $row['status']
    ];
}


if (isset($_POST['kembali'])) {
    $kodeBarang = $_POST['barang'];

   
    $sql = "UPDATE lenovo SET status = 'tersedia', peminjam = '' WHERE kode_barang = '$kodeBarang'";
    mysqli_query($server, $sql);

   
    unset($barangDipinjam[$kodeBarang]);

    $success = "Barang berhasil dikembalikan.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="laptop.css">
    <style>
        .image-container.dipinjam {
            background-color: #ff8989;
        }
        .kotak p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <object data="map.svg"></object>
    <nav class="navbar">
        <span class="close-button" onclick="toggleNavbar()">&times;</span>
        <img src="img/profile.png">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><img src="img/home.png" style="display: inline-block;">Halaman Utama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><img src="img/peng.png"style="display: inline-block;">Pengembalian</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cs.php"><img src="img/tel.png"style="display: inline-block;">Contact</a>
            </li>
        </ul>
    </nav>
    <div class="us">
        <h1>Pengembalian Barang</h1>
    </div>
    <div class="kotak">
    <?php foreach ($barangDipinjam as $kode => $barang) { ?>
        <div class="image-container dipinjam" onclick="openModal('<?php echo $kode; ?>')">
            <img src="img/vlap.png">
            <div class="overlay">
                <p>Nomor: <span style="padding-left: 5rem"><?php echo $barang['nama_barang']; ?></span></p> 
                <p>Status: <span style="padding-left: 3rem"><?php echo ($barang['status'] == 'tersedia') ? 'Tersedia' : 'Dipinjam'; ?></span></p>
            </div>
        </div>
    <?php } ?>
</div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>Pengembalian</h1>
        <img src="img/vlap.png" style="width:20%;">
        <form method="post">
            <select name="barang">
                <?php foreach ($barangDipinjam as $kode => $barang) { ?>
                    <option value="<?php echo $kode; ?>" >
                        <?php echo $barang['nama_barang']; ?>
                    </option>
                <?php } ?>
            </select>
            <button id="submitBtn" class="btn" type="submit" name="kembali">Pengembalian</button>
        </form>
    </div>
</div>

    <div class="success-message"><?php echo isset($success) ? $success : ''; ?></div>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function toggleNavbar() {
            const navbar = document.querySelector('.navbar');
            navbar.classList.toggle('closed');
        }
          // Fungsi untuk membuka modal
    function openModal(kodeBarang) {
        const modal = document.getElementById('myModal');
        const selectBarang = modal.querySelector('select[name="barang"]');
        selectBarang.value = kodeBarang;
        modal.style.display = 'block';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        const modal = document.getElementById('myModal');
        modal.style.display = 'none';
    }

    // Menambahkan event listener pada tombol close
    const closeBtn = document.getElementsByClassName('close')[0];
    closeBtn.addEventListener('click', closeModal);
    </script>
</body>
</html>

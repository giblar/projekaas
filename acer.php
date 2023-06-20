<?php
session_start();
require_once "koneksi_mysql.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

// Daftar barang 
$sql = "SELECT * FROM acer";
$result = mysqli_query($server, $sql);
$barangTersedia = [];
while ($row = mysqli_fetch_assoc($result)) {
    $barangTersedia[$row['kode_barang']] = [
        'nama_barang' => $row['nama_barang'],
        'status' => $row['status'],
        'peminjam' => $row['peminjam']
    ];
}

// Cek jika sudah ada data peminjaman
if (!isset($_SESSION['peminjaman'])) {
    $_SESSION['peminjaman'] = [];
}

// Proses peminjaman barang
if (isset($_POST['pinjam'])) {
    $kodeBarang = $_POST['barang'];

    // Cek apakah barang sedang dipinjam atau tidak
    if (in_array($kodeBarang, $_SESSION['peminjaman'])) {
        $error = "Barang sedang dipinjam. Harap kembalikan terlebih dahulu.";
    } else {
      
        $username = $_SESSION['username']; 
        $sql = "UPDATE acer SET status = 'dipinjam', peminjam = '$username' WHERE kode_barang = '$kodeBarang'";
        mysqli_query($server, $sql);

        $_SESSION['peminjaman'][] = $kodeBarang;
        $success = "Barang berhasil dipinjam.";

       
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}

// pengembalian
if (isset($_POST['kembali'])) {
    $kodeBarang = $_POST['barang'];

   
    $sql = "UPDATE acer SET status = 'tersedia', peminjam = '' WHERE kode_barang = '$kodeBarang'";
    mysqli_query($server, $sql);

    
    $_SESSION['peminjaman'] = array_diff($_SESSION['peminjaman'], [$kodeBarang]);
    $success = "Barang berhasil dikembalikan.";

    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

$modalSuccess = isset($success) ? $success : '';
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="laptop.css">
    <style>
        select {
            outline:none;
            border-radius: 10px;
            border: none;
            background-color: #fff;
        }

        .image-container.dipinjam {
            background-color: #ff8989;
        }
        .kotak p{
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
                <a class="nav-link" href="index.php"><img src="img/home.png" style=" display: inline-block;">Halaman Utama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="pengembalian.php"><img src="img/peng.png"style=" display: inline-block;  "> Pengembalian</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cs.php"><img src="img/tel.png"style=" display: inline-block;">Contact</a>
            </li>
        </ul>
    </nav>
    <div class="us">
        <h1>ACER</h1>
    </div>
    <div class="kotak">
        <?php foreach ($barangTersedia as $kode => $barang) { ?>
            <div class="image-container <?php echo ($barang['status'] == 'dipinjam') ? 'dipinjam' : ''; ?>">
                <img src="img/vlap.png">
                <div class="overlay">
                   <p>Nomor: <span style="padding-left: 5rem"><?php echo $barang['nama_barang']; ?></span></p> 
                   <p>Status: <span style="padding-left: 3rem"><?php echo ($barang['status'] == 'tersedia') ? 'Tersedia' : 'Dipinjam'; ?></span></p>
                   <p>Peminjam: <span style="padding-left: 2rem"><?php echo ($barang['peminjam'] != '') ? $barang['peminjam'] : '-'; ?></span></p>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>Konfirmasi Peminjaman</h1>
            <img src="img/vlap.png" style="width:20%;">
            <form method="post">
                <select name="barang">
                    <?php foreach ($barangTersedia as $kode => $barang) { ?>
                        <option value="<?php echo $kode; ?>" <?php echo ($barang['status'] == 'dipinjam') ? 'disabled' : ''; ?>>
                            <?php echo $barang['nama_barang']; ?>
                        </option>
                    <?php } ?>
                </select>
                <button id="submitBtn" class="btn" type="submit" name="pinjam" onclick="openSuccessModal()">Submit</button>
            </form>
        </div>
    </div>

    <span class="open-button" onclick="toggleNavbar()">&#9776;</span>
    <script src="js/bootstrap.min.js"></script>
    <script>
        function toggleNavbar() {
            const navbar = document.querySelector('.navbar');
            navbar.classList.toggle('closed');
        }

        const modal = document.getElementById('myModal');
        const modalImg = document.getElementById('modalImg');
        const closeBtn = document.getElementsByClassName('close')[0];

        
        function openModal(imgSrc, nomorBarang) {
            modal.style.display = 'block';
            modalImg.src = imgSrc;
            document.querySelector('select[name="barang"]').value = nomorBarang;
        }

      
        function closeModal() {
            modal.style.display = 'none';
            modalImg.src = '';
        }

       
        const imageContainers = document.querySelectorAll('.image-container');
        imageContainers.forEach(function (container) {
        
            if (!container.classList.contains('dipinjam')) {
                container.addEventListener('click', function () {
                    const nomorBarang = this.querySelector('.overlay p:first-child').textContent.split(':')[1].trim();
                    const imgSrc = this.querySelector('img').src;
                    openModal(imgSrc, nomorBarang);
                });
            }
        });

       
        closeBtn.addEventListener('click', closeModal);
    </script>
</body>
</html>

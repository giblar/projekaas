<?php
session_start();
require_once "koneksi_mysql.php";


$sql = "SELECT * FROM barang";
$result = mysqli_query($server, $sql);
$barangTersedia = array();
while ($row = mysqli_fetch_assoc($result)) {
    $barangTersedia[$row['kode_barang']] = array(
        'nama_barang' => $row['nama_barang'],
        'status' => $row['status']
    );
}


if (!isset($_SESSION['peminjaman'])) {
    $_SESSION['peminjaman'] = array();
}


if (isset($_POST['pinjam'])) {
    $kodeBarang = $_POST['barang'];

   
    if (in_array($kodeBarang, $_SESSION['peminjaman'])) {
        $error = "Barang sedang dipinjam. Harap kembalikan terlebih dahulu.";
    } else {
       
        $sql = "UPDATE barang SET status = 'dipinjam' WHERE kode_barang = '$kodeBarang'";
        mysqli_query($server, $sql);

        $_SESSION['peminjaman'][] = $kodeBarang;
        $success = "Barang berhasil dipinjam.";
    }
}


if (isset($_POST['kembali'])) {
    $kodeBarang = $_POST['barang'];

   
    $sql = "UPDATE barang SET status = 'tersedia' WHERE kode_barang = '$kodeBarang'";
    mysqli_query($server, $sql);


    $_SESSION['peminjaman'] = array_diff($_SESSION['peminjaman'], [$kodeBarang]);
    $success = "Barang berhasil dikembalikan.";
}

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
            border-radius: 10px;
            border: none;
            background-color: #fff;
        }
        .image-container.dipinjam {
         background-color: #ff1e00;
         
        }
    </style>
</head>
<body>
    <object data="map.svg"></object>
    <nav class="navbar">
        <span class="close-button" onclick="toggleNavbar()">&times;</span>
        <img src="profile.png">
        <ul class="nav flex-column">
            <li class="nav-item"></li>
            <li class="nav-item">
                <a class="nav-link" href="index.php"><img src="home.png">Halaman Utama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="peminjaman.php"><img src="peng.png" alt="">Peminjaman Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><img src="tel.png" alt="">Contact</a>
            </li>
        </ul>
    </nav>
    <div class="us">
        <h1>LENOVO</h1>
    </div>
    <div class="kotak">
    <?php foreach ($barangTersedia as $kode => $barang) { ?>
        <div class="image-container <?php echo ($barang['status'] == 'dipinjam') ? 'dipinjam' : ''; ?>">
            <img src="vlap.png">
            <div class="overlay">
                <?php echo $barang['nama_barang']; ?>
            </div>
        </div>
    <?php } ?>
</div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>konfirmasi peminjaman</h1>
            <form method="post">
            <select name="barang">
    <?php foreach ($barangTersedia as $kode => $barang) { ?>
        <option value="<?php echo $kode; ?>" <?php echo ($barang['status'] == 'dipinjam') ? 'disabled' : ''; ?>>
            <?php echo $barang['nama_barang']; ?>
        </option>
    <?php } ?>
</select>

                <button id="submitBtn" class="btn" type="submit" name="pinjam">Submit</button>
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

        // membuka modal
        function openModal(imgSrc) {
            modal.style.display = 'block';
            modalImg.src = imgSrc;
        }

        //  menutup modal
        function closeModal() {
            modal.style.display = 'none';
            modalImg.src = '';
        }

    
        const imageContainers = document.querySelectorAll('.image-container');
        imageContainers.forEach(function (container) {
            container.addEventListener('click', function () {
                const imgSrc = this.querySelector('img').src;
                openModal(imgSrc);
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
        const imageContainers = document.querySelectorAll('.image-container');
        imageContainers.forEach(function(container) {
            const overlay = container.querySelector('.overlay');
            const status = overlay.innerText.trim();

            if (status === 'dipinjam') {
                container.style.backgroundColor = 'red';
                container.style.pointerEvents = 'none';
            } else {
                container.addEventListener('click', function() {
                    const imgSrc = this.querySelector('img').src;
                    openModal(imgSrc);
                });
            }
        });
    });

      
        closeBtn.addEventListener('click', closeModal);
    </script>
</body>
</html>

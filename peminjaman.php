<?php
include "koneksi_mysql.php";
$conn = mysqli_connect("localhost","root","","latihan_xpplg");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$nis = "";
$username = $_SESSION['username'];

$sql = "SELECT nis FROM tb_login WHERE username = '$username'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nis = $row['nis'];
} else {
    echo "Data tidak ditemukan";
}
if (!$result) {
    echo "Error: " . $conn->error;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style2.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
        *{
            font-family: 'Roboto', sans-serif;
        }
        h1{
            font-size: 5rem;
        }
        h4{
            font-size: 2rem;
        }
        h3{
            font-size: 3rem;
        }
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background-color: #FFFFFF;
            padding: 15px;
            z-index: 1;
            transition: transform 0.3s ease;
        }
        .navbar.closed {
            transform: translateX(-240px); /* Menyembunyikan navbar saat ditutup */
        }

        body {
            background-color: #1E90FF;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        object {
            position: fixed;
            top: -130px;
            right: 0px;
            width: calc(100% - 240px);
            height: 100%;
            z-index: -1;
        }

        .navbar img {
            width: 90px;
            height: 90px;
            display: block;
            margin: 10px auto;
        }

        .us {
            margin-left: 260px;
            font-family: serif;
            font-style: normal;
            color: #ffff;
        }

        .us p {
            margin-top: 20px;
        }

        .kotak {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;
            background-color: #F5F8FA;
            padding: 10px;
            top: 18vh;
            z-index: 0;
        }

        .kotak img {
            margin: 0 40px;
            border-radius: 12px;
            transition: transform 0.3s ease;
            max-width: 100%;
            height: auto;
        }

        .kotak img:hover {
            transform: scale(1.2);
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 24px;
        }
        .open-button {
            position: fixed;
            top: 15px;
            left: 15px;
            font-size: 20px;
            cursor: pointer;
            z-index: 2;
            color: #ffff;
        }
        .navbar ul img{
            width: 30px;
            height: 30px;
            margin-right:10px;
        }
       
        .navbar li {
            display: inline-block;
            margin-left: 0px;
            align-items: center;
            margin-bottom: 10px;
            margin-right:3px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .navbar li img {
            margin-left: 3px;
            width: 20px;
            height: 20px;
        }

        /* Media queries untuk perangkat dengan lebar 768px atau lebih kecil */
        @media (max-width: 768px) {
            .navbar {
                width: 100%;
                transform: translateX(-100%);
            }

            .us {
                margin-left: 0;
                text-align: center;
            }

            .kotak {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60vh;
    background-color: #F5F8FA;
    padding: 10px;
    top: 18vh;
    z-index: 0;
}

.kotak img {
    margin: 10px;
    max-width: 100%;
    height: auto;
}


            .open-button {
                left: 10px;
            }
            
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
            <li class="nav-item">
                <a href="logout.php"><img src="img/logout.png"style=" display: inline-block;">Keluar</a>
            </li>
        </ul>
    </nav>

    <div class="us">
        <h4>Selamat datang,</h4>
        <b><h1><?php echo $_SESSION['username']; ?></h1></b>
        <h4>PPLG-1220934-CISARUA 4</h4>
    </div>

    <div class="kotak">
        <a href="laptop.php"><img src="img/lenovo.png" style="margin-left:10rem;"></a> 
        <a href="hp.php"><img src="img/hps.png"></a>
        <a href="acer.php"><img src="img/acer.png"></a>
        <img src="img/leplane.png">
    </div>

    <span class="open-button" onclick="toggleNavbar()">&#9776;</span>

    <script src="js/bootstrap.min.js"></script>
    <script>
        function toggleNavbar() {
            const navbar = document.querySelector('.navbar');
            navbar.classList.toggle('closed');
        }
    </script>
</body>
</html>

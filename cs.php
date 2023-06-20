<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
 
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
        *{
            font-family: 'Roboto', sans-serif;
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

        }
       
        .navbar li {
            
            display: inline-block; /* Menampilkan li secara horizontal */
            margin-left: 0px; /* Memberi jarak antara li */
            align-items: center; /* Mengatur vertikal tengah */
            margin-bottom: 10px; /* Memberi jarak antara li */
            margin-right:3px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            
        }

        .navbar li img {
            margin-left: 3px; 
            width: 20px; 
            height: 20px; 
        }
        ul{
            margin-top:-1rem;
        }
        .card{
            left:20rem;
            top:8rem;
            width:80rem;
             height:36rem;
             background: linear-gradient(101.88deg, rgba(255, 255, 255, 0.56) 4.05%, rgba(255, 255, 255, 0.56) 48.89%, rgba(255, 255, 255, 0.56) 98.35%);
        }
        
        .card p{
            font-size:1.8rem;
            width:500px;
            font-weight:100;
        }
        .card img{
            position:absolute;
           margin-left:55rem;
           top:100px;
           
        }
        .card{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color:#585E97;
        }
        .card h1{
            width:400px;
        }
        .ad{
            background-color: #fff;
            width:400px;
            height:80px;
            padding-left:30px;
            padding-top:20px;
            border-radius:10px;
            border: 1px;
           

        }

        
        @media (max-width: 768px) {
            .navbar {
                width: 100%;
                transform: translateX(-100%);
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
        <ul class="nav flex-column" style=" margin-top:-1rem;">
       
            <li class="nav-item">
                <a class="nav-link" href="index.php"><img src="img/home.png" style=" display: inline-block;">Halaman Utama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="peminjaman.php"><img src="img/peng.png"style=" display: inline-block;  "> Peminjaman Barang</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><img src="img/tel.png"style=" display: inline-block;">Contact</a>
            </li>
        </ul>
    </nav>
    <div class="card">
        <div class="card-body">
        <h1>kontak CS untuk informasi lebih lanjut</h1><hr>
        <p>Bila memiliki masalah, keluhan,pertanyaan,silakan hubungi email berikut</p>
        <div class="ad"><p>admin@gmail.com</p></div>
        <img src="logo-orang.png" >
        </div>
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

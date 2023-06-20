<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: peminjaman.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "latihan_xpplg");
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    

    // sql statement
    $stmt = mysqli_prepare($conn, "SELECT * FROM tb_login WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $data['username'];
        header("Location: peminjaman.php");
        exit();
    } if(empty($username )) {
        $error1 = true;
    } if(empty($password )) {
        $error1 = true;
    }else {
        $error =true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>projek</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
   
        object {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .card-body {
            margin: 20px 50px;
        }

        body {
            background: url(img/bg.png) no-repeat center center fixed;
            background-size: cover;
            height:90%;
            color: #7E7F80;
            background-color: #1E90FF;
        }

        .teks {
            font-size: 10vw;
            padding: 20px;
            color: white;
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }

        .card-title {
            color: #716B6B;
        }

        .card {
            
            box-shadow: 35px 31px 16px -5px rgba(0, 0, 0, 0.13);
            -webkit-box-shadow: 35px 31px 16px -5px rgba(0, 0, 0, 0.13);
            -moz-box-shadow: 35px 31px 16px -5px rgba(0, 0, 0, 0.13);
        }

        .card-container {
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            height: 100vh;
            padding-top: 50px;
            padding-right: 50px;
        }

        /* Media queries untuk perangkat dengan lebar 768px atau lebih kecil */
        @media (max-width: 768px) {
            .teks {
                font-size: 6vw;
                padding: 10px;
            }

            .card-container {
                justify-content: center;
                padding: 50px;
            }

            .card {
                width: 100%;
            }

            .card-body {
                margin: 20px;
            }

            .d-grid {
                margin-top: 20px;
            }
        }

        /* Media queries untuk perangkat dengan lebar 576px atau lebih kecil */
        @media (max-width: 576px) {
            .card-container {
                padding: 20px;
            }

            .card-body {
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <object data="map.svg"></object>
    <div class="teks">
        <h1 style="font-size: 80px;">WeLend</h1>
        <h5>peminjaman menjadi lebih mudah</h5>
    </div>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                    <div class="form-container">
           <?php if(isset($error)) { ?>
       
         <div class="alert alert-danger"> 
           salah </div>
            <?php } ?></h1>
           

            <div class="form-container">
           <?php if(isset($error1)) { ?>
       
         <div class="alert alert-danger"> 
           username/password tidak boleh kosong </div>
            <?php } ?></h1>

                        <h2 class="card-title">Silahkan login terlebih dahulu</h2>
                        <form method="POST" action="" >
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="text" class="form-control" name="username" 
                                    style="background:#D9D9D9;" placeholder="giblar">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label" >Password</label>
                                <input type="password" class="form-control"  name="password"  id="exampleInputPassword1"
                                    style="background:#D9D9D9;" placeholder="abc">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Simpan login</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" type="submit" value="Login"
                                    style="background:#A39797; height:40px; width:100px;">MASUK</button>
                                <br>
                                <h7>Hubungi customer service jika bermasalah <a href="cs.php">CS</a></h7>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>


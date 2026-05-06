<?php
require 'function.php';

// Cek login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cekdatabase = mysqli_query($conn, "SELECT * FROM login WHERE email='$email' AND password='$password'");
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        $_SESSION['log'] = true;
        header('Location: index.php');
        exit;
    } else {
        header('Location: login.php');
        exit;
    }
}

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['log'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="StockHub ATK Management - Sistem pengelolaan stok ATK." />
    <meta name="author" content="StockHub ATK Management" />
    <title>Login | StockHub ATK Management</title>

    <link href="css/styles.css" rel="stylesheet" />
    <link href="image/logo.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background:
                linear-gradient(rgba(13, 42, 79, 0.72), rgba(13, 42, 79, 0.72)),
                url('image/gudang1.jpg') no-repeat center center/cover;
            min-height: 100vh;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 540px;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        }

        .login-header {
            padding: 32px 32px 20px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }

        .login-header img {
            max-width: 320px;
            width: 100%;
            height: auto;
            margin-bottom: 12px;
        }

        .brand-subtitle {
            font-size: 14px;
            color: #5f6b7a;
            margin: 0;
        }

        .login-body {
            padding: 28px 32px 32px;
        }

        .welcome-title {
            font-size: 24px;
            font-weight: 700;
            color: #123a63;
            text-align: center;
            margin-bottom: 8px;
        }

        .welcome-text {
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .form-control {
            height: 56px;
            border-radius: 12px;
            border: 1px solid #d6dde5;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #2f80ed;
            box-shadow: 0 0 0 0.2rem rgba(47, 128, 237, 0.15);
        }

        .form-floating > label {
            color: #6c757d;
        }

        .btn-stockhub {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(90deg, #1155b3 0%, #2f9df4 100%);
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            transition: 0.25s ease-in-out;
        }

        .btn-stockhub:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(17, 85, 179, 0.25);
        }

        .login-footer {
            text-align: center;
            padding-top: 16px;
            color: #8a94a6;
            font-size: 13px;
        }

        @media (max-width: 576px) {
            .login-header,
            .login-body {
                padding-left: 20px;
                padding-right: 20px;
            }

            .login-header img {
                max-width: 250px;
            }

            .welcome-title {
                font-size: 21px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <img src="image/logo2.png" alt="Logo StockHub">
                <p class="brand-subtitle">Pusat pengelolaan stok ATK yang terintegrasi, rapi, dan efisien.</p>
            </div>

            <div class="login-body">
                <h1 class="welcome-title">Selamat Datang</h1>
                <p class="welcome-text">
                    Masuk ke sistem <strong>StockHub ATK Management</strong> untuk mengelola
                    data barang, transaksi masuk dan keluar, serta laporan inventaris dengan lebih terstruktur.
                </p>

                <form method="post">
                    <div class="form-floating mb-3">
                        <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" required />
                        <label for="inputEmail">Email address</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" required />
                        <label for="inputPassword">Password</label>
                    </div>

                    <div class="mt-4">
                        <button class="btn-stockhub" name="login" type="submit">
                            <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk ke Sistem
                        </button>
                    </div>
                </form>

                <div class="login-footer">
                    © <?php echo date('Y'); ?> StockHub ATK Management
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
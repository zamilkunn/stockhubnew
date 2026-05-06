<?php
require 'function.php';
require 'cek.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="StockHub ATK Management - Kelola Admin" />
    <meta name="author" content="StockHub ATK Management" />
    <title>Kelola Admin | StockHub ATK Management</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="image/logo.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        body {
            background: #f4f8fc;
        }

        .sb-topnav {
            background: linear-gradient(90deg, #114b9b 0%, #2f9df4 100%) !important;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .sb-sidenav {
            background: #123a63 !important;
        }

        .sb-sidenav .nav-link {
            color: rgba(255,255,255,0.88);
            border-radius: 12px;
            margin: 4px 10px;
            padding: 12px 14px;
            transition: 0.2s ease-in-out;
        }

        .sb-sidenav .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .sb-sidenav .nav-link.active {
            background: linear-gradient(90deg, #1155b3 0%, #2f9df4 100%);
            color: #fff;
        }

        .page-title {
            font-weight: 700;
            color: #123a63;
            margin-bottom: 4px;
        }

        .page-subtitle {
            color: #6c757d;
            margin-bottom: 24px;
        }

        .main-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(18, 58, 99, 0.08);
            overflow: hidden;
        }

        .main-card .card-header {
            background: #fff;
            border-bottom: 1px solid #eef2f6;
            padding: 18px 22px;
        }

        .btn-stockhub {
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 600;
            background: linear-gradient(90deg, #1155b3 0%, #2f9df4 100%);
            color: #fff;
        }

        .btn-stockhub:hover {
            color: #fff;
            opacity: 0.96;
        }

        .btn-warning,
        .btn-danger,
        .btn-primary {
            border-radius: 10px;
        }

        .footer-brand {
            color: #6c757d;
        }

        .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(90deg, #1155b3 0%, #2f9df4 100%);
            color: #fff;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-control,
        .form-select {
            border-radius: 10px;
        }

        .input-group .btn {
            border-radius: 0 10px 10px 0 !important;
        }
    </style>
</head>

<body class="sb-nav-fixed">

<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <a class="navbar-brand ps-3 pe-3" href="index.php">
        <i class="fas fa-boxes-stacked me-2"></i>
        <span class="brand-text">StockHub ATK Management</span>
    </a>

    <button class="btn btn-link btn-sm order-1 order-lg-0 ms-auto me-3 text-white"
        id="sidebarToggle" type="button">
        <i class="fas fa-bars"></i>
    </button>
</nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav pt-3">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-boxes-stacked"></i></div>
                            Data Stok
                        </a>

                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-down"></i></div>
                            Barang Masuk
                        </a>

                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-up"></i></div>
                            Barang Keluar
                        </a>

                        <a class="nav-link active" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                            Kelola Admin
                        </a>

                        <div class="mt-auto pt-5"></div>

                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-right-from-bracket"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4 py-4">
                    <h1 class="page-title">Kelola Admin</h1>
                    <p class="page-subtitle">
                        Atur akun admin untuk menjaga pengelolaan StockHub tetap aman, terpusat, dan terkontrol.
                    </p>

                    <div class="card main-card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <strong>Daftar Admin</strong><br>
                                <small class="text-muted">Manajemen akun pengguna admin sistem.</small>
                            </div>
                            <button type="button" class="btn btn-stockhub" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fas fa-user-plus me-2"></i>Tambah Admin
                            </button>
                        </div>

                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Email Admin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambilsemuadataadmin = mysqli_query($conn, "SELECT * FROM login");
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadataadmin)) {
                                        $em = $data['email'];
                                        $iduser = $data['iduser'];
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $em; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $iduser; ?>">
                                                    <i class="fas fa-pen me-1"></i>Edit
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete<?= $iduser; ?>">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="edit<?= $iduser; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit Admin</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="email" name="emailadmin" value="<?= $em; ?>" class="form-control mb-3" placeholder="Email Admin" required>

                                                            <div class="input-group mb-3">
                                                                <input type="password" name="passwordbaru" class="form-control password-field" placeholder="Password Baru" required>
                                                                <button type="button" class="btn btn-outline-secondary toggle-password">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </div>

                                                            <div class="input-group mb-3">
                                                                <input type="password" name="passwordbaru2" class="form-control password-field" placeholder="Konfirmasi Password Baru" required>
                                                                <button type="button" class="btn btn-outline-secondary toggle-password">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </div>

                                                            <input type="hidden" name="id" value="<?= $iduser; ?>">
                                                            <button type="submit" class="btn btn-stockhub w-100" name="updateadmin">
                                                                Simpan Perubahan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="delete<?= $iduser; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus Admin</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <p class="mb-3">Apakah Anda yakin ingin menghapus akun admin <strong><?= $em; ?></strong>?</p>
                                                            <input type="hidden" name="id" value="<?= $iduser; ?>">
                                                            <button type="submit" class="btn btn-danger w-100" name="hapusadmin">
                                                                Ya, Hapus Admin
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-white mt-auto border-top">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small flex-wrap gap-2">
                        <div class="footer-brand">
                            © <?php echo date('Y'); ?> StockHub ATK Management
                        </div>
                        <div class="footer-brand">
                            Sistem inventaris ATK yang rapi, terstruktur, dan efisien.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Admin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post">
                    <div class="modal-body">
                        <input type="email" name="email" placeholder="Email Admin" class="form-control mb-3" required>

                        <div class="input-group mb-3">
                            <input type="password" name="password" placeholder="Password" class="form-control password-field" required>
                            <button type="button" class="btn btn-outline-secondary toggle-password">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn btn-stockhub w-100" name="addadmin">
                            Simpan Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(button) {
            button.addEventListener('click', function () {
                const input = this.parentElement.querySelector('.password-field');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
</body>
</html>
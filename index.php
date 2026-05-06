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
    <meta name="description" content="StockHub ATK Management - Sistem pengelolaan stok barang ATK." />
    <meta name="author" content="StockHub ATK Management" />
    <title>Dashboard | StockHub ATK Management</title>

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

        .alert-stock {
            border: none;
            border-radius: 14px;
            background: #fff1f1;
            color: #b42318;
            box-shadow: 0 6px 18px rgba(180, 35, 24, 0.08);
        }

        table#datatablesSimple {
            width: 100%;
        }

        .dataTable-wrapper .dataTable-top,
        .dataTable-wrapper .dataTable-bottom {
            padding: 12px 0;
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
                        <a class="nav-link active" href="index.php">
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

                        <a class="nav-link" href="admin.php">
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
                    <h1 class="page-title">Dashboard Stok ATK</h1>
                    <p class="page-subtitle">
                        Kelola data barang, pantau stok, dan pastikan kebutuhan ATK tetap terkontrol.
                    </p>

                    <div class="card main-card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <strong>Daftar Stok Barang</strong><br>
                                <small class="text-muted">Informasi stok barang ATK yang tersedia saat ini.</small>
                            </div>
                            <button type="button" class="btn btn-stockhub" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fas fa-plus me-2"></i>Tambah Barang
                            </button>
                        </div>

                        <div class="card-body">

                            <?php
                            // ✅ Query stok habis dengan pengecekan error
                            $ambildatastock = mysqli_query($conn, "SELECT * FROM stock WHERE stock < 1");

                            if ($ambildatastock === false) {
                                echo '<div class="alert alert-danger">Error query stok habis: ' . mysqli_error($conn) . '</div>';
                            } else {
                                while ($fetch = mysqli_fetch_array($ambildatastock)) {
                                    $barang = htmlspecialchars($fetch['namabarang']);
                            ?>
                                    <div class="alert alert-stock alert-dismissible fade show" role="alert">
                                        <strong>Perhatian!</strong> Stok <b><?= $barang; ?></b> telah habis.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                            <?php
                                } // end while
                            } // end if
                            ?>

                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // ✅ Query semua stok dengan pengecekan error
                                    $ambilsemuadatastock = mysqli_query($conn, "SELECT * FROM stock");

                                    if ($ambilsemuadatastock === false) {
                                        echo '<tr><td colspan="5" class="text-danger text-center">Error query data stok: ' . mysqli_error($conn) . '</td></tr>';
                                    } else {
                                        $i = 1;
                                        while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                            $namabarang = htmlspecialchars($data['namabarang']);
                                            $deskripsi  = htmlspecialchars($data['deskripsi']);
                                            $stock = $data['stock'];
                                            $idb        = $data['idbarang'];
                                    ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $namabarang; ?></td>
                                                <td><?= $deskripsi; ?></td>
                                                <td><?= $stock; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $idb; ?>">
                                                        <i class="fas fa-pen me-1"></i>Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete<?= $idb; ?>">
                                                        <i class="fas fa-trash me-1"></i>Hapus
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit -->
                                            <div class="modal fade" id="edit<?= $idb; ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Edit Barang</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <label class="form-label fw-semibold">Nama Barang</label>
                                                                <input type="text" name="namabarang" value="<?= $namabarang; ?>" class="form-control mb-3" required>
                                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                                <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control mb-3" required>
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <button type="submit" class="btn btn-stockhub w-100" name="updatebarang">
                                                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Hapus -->
                                            <div class="modal fade" id="delete<?= $idb; ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Hapus Barang</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form method="post">
                                                            <div class="modal-body">
                                                                <p class="mb-3">Apakah Anda yakin ingin menghapus <strong><?= $namabarang; ?></strong>?</p>
                                                                <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                                <button type="submit" class="btn btn-danger w-100" name="hapusbarang">
                                                                    <i class="fas fa-trash me-2"></i>Ya, Hapus Barang
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php
                                        } // end while
                                    } // end if
                                    ?>
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

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="myModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" name="namabarang" placeholder="Contoh: Pulpen Hitam" class="form-control mb-3" required>
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <input type="text" name="deskripsi" placeholder="Contoh: Pulpen tinta hitam ukuran 0.5mm" class="form-control mb-3" required>
                        <label class="form-label fw-semibold">Jumlah Stok</label>
                        <input type="number" name="stock" class="form-control mb-3" placeholder="Contoh: 100" min="0" required>
                        <button type="submit" class="btn btn-stockhub w-100" name="addnewbarang">
                            <i class="fas fa-plus me-2"></i>Simpan Barang
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
</body>
</html>
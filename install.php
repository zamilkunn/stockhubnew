<?php
/**
 * StockHub - Database Installer
 * Buka halaman ini 1x setelah deploy untuk setup database.
 * URL: https://your-app.onrender.com/install.php
 */

// Load koneksi database
require 'function.php';

$messages = [];
$errors = [];

// Buat tabel stock
$sql1 = "CREATE TABLE IF NOT EXISTS `stock` (
  `idbarang` int(11) NOT NULL AUTO_INCREMENT,
  `namabarang` varchar(50) NOT NULL,
  `deskripsi` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(99) DEFAULT NULL,
  PRIMARY KEY (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql1)) {
    $messages[] = "✅ Tabel 'stock' berhasil dibuat";
} else {
    $errors[] = "❌ Tabel 'stock': " . mysqli_error($conn);
}

// Buat tabel login
$sql2 = "CREATE TABLE IF NOT EXISTS `login` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql2)) {
    $messages[] = "✅ Tabel 'login' berhasil dibuat";
} else {
    $errors[] = "❌ Tabel 'login': " . mysqli_error($conn);
}

// Buat tabel masuk
$sql3 = "CREATE TABLE IF NOT EXISTS `masuk` (
  `idmasuk` int(11) NOT NULL AUTO_INCREMENT,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`idmasuk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql3)) {
    $messages[] = "✅ Tabel 'masuk' berhasil dibuat";
} else {
    $errors[] = "❌ Tabel 'masuk': " . mysqli_error($conn);
}

// Buat tabel keluar
$sql4 = "CREATE TABLE IF NOT EXISTS `keluar` (
  `idkeluar` int(11) NOT NULL AUTO_INCREMENT,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `penerima` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`idkeluar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

if (mysqli_query($conn, $sql4)) {
    $messages[] = "✅ Tabel 'keluar' berhasil dibuat";
} else {
    $errors[] = "❌ Tabel 'keluar': " . mysqli_error($conn);
}

// Insert default admin (jika belum ada)
$cek = mysqli_query($conn, "SELECT * FROM login LIMIT 1");
if (mysqli_num_rows($cek) == 0) {
    $sql5 = "INSERT INTO `login` (`email`, `password`) VALUES ('admin@stockhub.com', 'admin123');";
    if (mysqli_query($conn, $sql5)) {
        $messages[] = "✅ Admin default berhasil ditambahkan (admin@stockhub.com / admin123)";
    } else {
        $errors[] = "❌ Insert admin: " . mysqli_error($conn);
    }
} else {
    $messages[] = "ℹ️ Admin sudah ada, skip insert";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockHub - Database Installer</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #0d2a4f; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .card { background: #fff; border-radius: 16px; padding: 40px; max-width: 600px; width: 100%; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        h1 { color: #123a63; margin-bottom: 8px; font-size: 24px; }
        .subtitle { color: #6c757d; margin-bottom: 24px; }
        .msg { padding: 10px 16px; border-radius: 8px; margin-bottom: 8px; font-size: 14px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .info { background: #d1ecf1; color: #0c5460; margin-top: 20px; padding: 16px; border-radius: 8px; }
        a { display: inline-block; margin-top: 20px; background: linear-gradient(90deg, #1155b3, #2f9df4); color: #fff; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; }
        a:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(17,85,179,0.3); }
    </style>
</head>
<body>
    <div class="card">
        <h1>🛠️ StockHub Database Installer</h1>
        <p class="subtitle">Hasil instalasi database:</p>

        <?php foreach ($messages as $msg): ?>
            <div class="msg success"><?= $msg ?></div>
        <?php endforeach; ?>

        <?php foreach ($errors as $err): ?>
            <div class="msg error"><?= $err ?></div>
        <?php endforeach; ?>

        <?php if (empty($errors)): ?>
            <div class="info">
                <strong>🎉 Database berhasil di-setup!</strong><br>
                Login: <strong>admin@stockhub.com</strong> / <strong>admin123</strong><br>
                <small>Hapus file install.php setelah selesai untuk keamanan.</small>
            </div>
            <a href="login.php">→ Buka StockHub</a>
        <?php else: ?>
            <div class="info" style="background:#f8d7da;color:#721c24;">
                <strong>Ada error!</strong> Cek environment variables di Render.
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

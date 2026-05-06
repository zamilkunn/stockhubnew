<?php
session_start();
ob_start();

// Koneksi database (support environment variable untuk production)
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASS') ?: '';
$db_name = getenv('DB_NAME') ?: 'stockbarang';
$db_port = getenv('DB_PORT') ?: 3306;
$db_ssl  = getenv('DB_SSL') ?: 'false';

$conn = mysqli_init();

// Aiven MySQL memerlukan SSL
if ($db_ssl === 'true') {
    mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
    mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, (int)$db_port, NULL, MYSQLI_CLIENT_SSL);
} else {
    mysqli_real_connect($conn, $db_host, $db_user, $db_pass, $db_name, (int)$db_port);
}

if (!$conn || mysqli_connect_errno()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset untuk kompatibilitas
mysqli_set_charset($conn, "utf8mb4");

/* =========================
   STOCK BARANG
========================= */

// Tambah barang baru
if (isset($_POST['addnewbarang'])) {
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $stok = (int) $_POST['stock'];

    // ✅ Kolom diganti: stock → stok
    $insert = mysqli_query($conn, "INSERT INTO stock (namabarang, deskripsi, stock) 
                                   VALUES ('$namabarang', '$deskripsi', '$stok')");

    if ($insert) {
        header('location:index.php');
        exit;
    } else {
        echo 'Gagal tambah barang: ' . mysqli_error($conn);
    }
}

// Update info barang
if (isset($_POST['updatebarang'])) {
    $idb        = (int) $_POST['idb'];
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', 
                                   deskripsi='$deskripsi' WHERE idbarang='$idb'");

    if ($update) {
        header('location:index.php');
        exit;
    } else {
        echo 'Gagal update barang: ' . mysqli_error($conn);
    }
}

// Hapus barang dari stock
if (isset($_POST['hapusbarang'])) {
    $idb = (int) $_POST['idb'];

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");

    if ($hapus) {
        header('location:index.php');
        exit;
    } else {
        echo 'Gagal hapus barang: ' . mysqli_error($conn);
    }
}

/* =========================
   BARANG MASUK
========================= */

// Menambah barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = (int) $_POST['barangnya'];
    $penerima  = mysqli_real_escape_string($conn, $_POST['penerima']);
    $qty       = (int) $_POST['qty'];

    $cek  = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $data = mysqli_fetch_array($cek);

    if (!$data) {
        echo 'Barang tidak ditemukan';
        exit;
    }

    // ✅ Ambil nilai dari kolom 'stok' bukan 'stock'
    $stokbaru = (int) $data['stock'] + $qty;

    $addtomasuk       = mysqli_query($conn, "INSERT INTO masuk (idbarang, keterangan, qty) 
                                             VALUES ('$barangnya','$penerima','$qty')");
    // ✅ Update kolom 'stok' bukan 'stock'
    $updatestockmasuk = mysqli_query($conn, "UPDATE stock SET stock='$stokbaru' 
                                             WHERE idbarang='$barangnya'");

    if ($addtomasuk && $updatestockmasuk) {
        header('location:masuk.php');
        exit;
    } else {
        echo 'Gagal menambah barang masuk: ' . mysqli_error($conn);
    }
}

// Mengubah data barang masuk
if (isset($_POST['updatebarangmasuk'])) {
    $idb        = (int) $_POST['idb'];
    $idm        = (int) $_POST['idm'];
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $qty        = (int) $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya   = mysqli_fetch_array($lihatstock);
    // ✅ Ambil nilai dari kolom 'stok'
    $stockskrg  = (int) $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idm'");
    $qtynya  = mysqli_fetch_array($qtyskrg);
    $qtylama = (int) $qtynya['qty'];

    $stokbaru = ($qty > $qtylama)
        ? $stockskrg + ($qty - $qtylama)
        : $stockskrg - ($qtylama - $qty);

    // ✅ Update kolom 'stok'
    $updatestock = mysqli_query($conn, "UPDATE stock SET stock='$stokbaru' WHERE idbarang='$idb'");
    $updatemasuk = mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$keterangan' 
                                        WHERE idmasuk='$idm'");

    if ($updatestock && $updatemasuk) {
        header('location:masuk.php');
        exit;
    } else {
        echo 'Gagal update barang masuk: ' . mysqli_error($conn);
    }
}

// Menghapus barang masuk
if (isset($_POST['hapusbarangmasuk'])) {
    $idb = (int) $_POST['idb'];
    $qty = (int) $_POST['kty'];
    $idm = (int) $_POST['idm'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data         = mysqli_fetch_array($getdatastock);
    // ✅ Ambil nilai dari kolom 'stok'
    $stokbaru     = (int) $data['stock'] - $qty;

    // ✅ Update kolom 'stok'
    $update    = mysqli_query($conn, "UPDATE stock SET stock='$stokbaru' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idm'");

    if ($update && $hapusdata) {
        header('location:masuk.php');
        exit;
    } else {
        echo 'Gagal hapus barang masuk: ' . mysqli_error($conn);
    }
}

/* =========================
   BARANG KELUAR
========================= */

// Menambah barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = (int) $_POST['barangnya'];
    $penerima  = mysqli_real_escape_string($conn, $_POST['penerima']);
    $qty       = (int) $_POST['qty'];

    $cek  = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $data = mysqli_fetch_array($cek);

    if (!$data) {
        echo 'Barang tidak ditemukan';
        exit;
    }

    // ✅ Cek stok dari kolom 'stok'
    if ($qty > (int) $data['stock']) {
        echo "<script>alert('Stok tidak mencukupi!'); history.back();</script>";
        exit;
    }

    // ✅ Kurangi dari kolom 'stok'
    $stokbaru = (int) $data['stock'] - $qty;

    $addtokeluar       = mysqli_query($conn, "INSERT INTO keluar (idbarang, penerima, qty) 
                                              VALUES ('$barangnya','$penerima','$qty')");
    // ✅ Update kolom 'stok'
    $updatestockkeluar = mysqli_query($conn, "UPDATE stock SET stock='$stokbaru' 
                                              WHERE idbarang='$barangnya'");

    if ($addtokeluar && $updatestockkeluar) {
        header('location:keluar.php');
        exit;
    } else {
        echo 'Gagal menambah barang keluar: ' . mysqli_error($conn);
    }
}

// Mengubah data barang keluar
if (isset($_POST['updatebarangkeluar'])) {
    $idb      = (int) $_POST['idb'];
    $idk      = (int) $_POST['idk'];
    $penerima = mysqli_real_escape_string($conn, $_POST['penerima']);
    $qty      = (int) $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $stocknya   = mysqli_fetch_array($lihatstock);
    // ✅ Ambil dari kolom 'stok'
    $stockskrg  = (int) $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idk'");
    $qtynya  = mysqli_fetch_array($qtyskrg);
    $qtylama = (int) $qtynya['qty'];

    $stokbaru = ($qty > $qtylama)
        ? $stockskrg - ($qty - $qtylama)
        : $stockskrg + ($qtylama - $qty);

    // ✅ Update kolom 'stok'
    $updatestock  = mysqli_query($conn, "UPDATE stock SET stock='$stokbaru' WHERE idbarang='$idb'");
    $updatekeluar = mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' 
                                         WHERE idkeluar='$idk'");

    if ($updatestock && $updatekeluar) {
        header('location:keluar.php');
        exit;
    } else {
        echo 'Gagal update barang keluar: ' . mysqli_error($conn);
    }
}

// Menghapus barang keluar
if (isset($_POST['hapusbarangkeluar'])) {
    $idb = (int) $_POST['idb'];
    $qty = (int) $_POST['kty'];
    $idk = (int) $_POST['idk'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data         = mysqli_fetch_array($getdatastock);
    // ✅ Ambil dari kolom 'stok'
    $stokbaru     = (int) $data['stock'] + $qty;

    // ✅ Update kolom 'stok'
    $update    = mysqli_query($conn, "UPDATE stock SET stock='$stokbaru' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idk'");

    if ($update && $hapusdata) {
        header('location:keluar.php');
        exit;
    } else {
        echo 'Gagal hapus barang keluar: ' . mysqli_error($conn);
    }
}

/* =========================
   ADMIN
========================= */

// Menambah admin baru
if (isset($_POST['addadmin'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $queryinsert = mysqli_query($conn, "INSERT INTO login (email, password) 
                                        VALUES ('$email','$password')");

    if ($queryinsert) {
        header('location:admin.php');
        exit;
    } else {
        echo 'Gagal tambah admin: ' . mysqli_error($conn);
    }
}

// Edit data admin
if (isset($_POST['updateadmin'])) {
    $emailbaru     = mysqli_real_escape_string($conn, $_POST['emailadmin']);
    $passwordbaru  = $_POST['passwordbaru'];
    $passwordbaru2 = $_POST['passwordbaru2'];
    $idnya         = (int) $_POST['id'];

    if ($passwordbaru === $passwordbaru2) {
        $passwordbaru = mysqli_real_escape_string($conn, $passwordbaru);
        $queryupdate  = mysqli_query($conn, "UPDATE login SET email='$emailbaru', 
                                             password='$passwordbaru' WHERE iduser='$idnya'");

        if ($queryupdate) {
            header('location:admin.php');
            exit;
        } else {
            echo 'Gagal update admin: ' . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Password tidak sama'); window.location='admin.php';</script>";
        exit;
    }
}

// Hapus admin
if (isset($_POST['hapusadmin'])) {
    $id = (int) $_POST['id'];

    $querydelete = mysqli_query($conn, "DELETE FROM login WHERE iduser='$id'");

    if ($querydelete) {
        header('location:admin.php');
        exit;
    } else {
        echo 'Gagal hapus admin: ' . mysqli_error($conn);
    }
}
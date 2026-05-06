<?php
require 'function.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Barang_Masuk.xls");

$query = mysqli_query($conn, "SELECT m.tanggal, s.namabarang, m.qty, m.keterangan 
                              FROM masuk m
                              JOIN stock s ON s.idbarang = m.idbarang
                              ORDER BY m.tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Masuk</title>
</head>
<body>
    <h3>Laporan Barang Masuk - StockHub ATK Management</h3>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_array($query)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['tanggal']; ?></td>
            <td><?= $data['namabarang']; ?></td>
            <td><?= $data['qty']; ?></td>
            <td><?= $data['keterangan']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
<?php
require 'function.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Barang_Keluar.xls");

$query = mysqli_query($conn, "SELECT k.tanggal, s.namabarang, k.qty, k.penerima 
                              FROM keluar k
                              JOIN stock s ON s.idbarang = k.idbarang
                              ORDER BY k.tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Keluar</title>
</head>
<body>
    <h3>Laporan Barang Keluar - StockHub ATK Management</h3>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Penerima</th>
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
            <td><?= $data['penerima']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
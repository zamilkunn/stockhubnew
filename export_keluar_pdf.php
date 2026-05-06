<?php
require 'function.php';

$query = mysqli_query($conn, "SELECT k.tanggal, s.namabarang, k.qty, k.penerima 
                              FROM keluar k
                              JOIN stock s ON s.idbarang = k.idbarang
                              ORDER BY k.tanggal DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Barang Keluar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #222;
        }
        h2, p {
            text-align: center;
            margin: 0;
        }
        p {
            margin-bottom: 20px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            font-size: 14px;
        }
        th {
            background: #eaf2ff;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom:20px; text-align:right;">
        <button onclick="window.print()">Print / Save as PDF</button>
    </div>

    <h2>StockHub ATK Management</h2>
    <p>Laporan Barang Keluar</p>

    <table>
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
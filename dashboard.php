<?php

require_once 'classes/Produk.php';
require_once 'classes/Transaksi.php';

$produk = new Produk();
$transaksi = new Transaksi();

$dataProduk = $produk->tampilProduk();
$stokMenipis = $produk->cekStokMenipis();
$rekap = $transaksi->rekapTransaksi();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Dashboard Inventaris
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
        }

        h2 {
            margin-top: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .warning {
            color: red;
            font-weight: bold;
            background-color: #ffe5e5;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

    </style>

</head>

<body>

    <h1>
        Dashboard Inventaris
    </h1>

    <h2>
        Data Produk
    </h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>

        <?php while($row = $dataProduk->fetch(PDO::FETCH_ASSOC)) { ?>

        <tr>

            <td>
                <?= $row['id']; ?>
            </td>

            <td>
                <?= $row['nama']; ?>
            </td>

            <td>
                <?= $row['kategori']; ?>
            </td>

            <td>
                Rp <?= number_format($row['harga']); ?>
            </td>

            <td>
                <?= $row['stok']; ?>
            </td>

        </tr>

        <?php } ?>

    </table>

    <h2>
        Peringatan Stok Menipis
    </h2>

    <?php

    while($stok = $stokMenipis->fetch(PDO::FETCH_ASSOC)) {

        echo "<div class='warning'>";

        echo "Produk <b>" .
             $stok['nama'] .
             "</b> stok tersisa <b>" .
             $stok['stok'] .
             "</b>";

        echo "</div>";
    }

    ?>

    <h2>
        Rekap Transaksi
    </h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>

        <?php while($trx = $rekap->fetch(PDO::FETCH_ASSOC)) { ?>

        <tr>

            <td>
                <?= $trx['id']; ?>
            </td>

            <td>
                <?= $trx['nama']; ?>
            </td>

            <td>
                <?= $trx['jumlah']; ?>
            </td>

            <td>
                <?= $trx['tanggal']; ?>
            </td>

        </tr>

        <?php } ?>

    </table>

</body>
</html>
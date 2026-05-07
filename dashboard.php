<?php

require_once 'classes/Produk.php';
require_once 'classes/Transaksi.php';

$produk = new Produk();
$transaksi = new Transaksi();

$dataProduk = $produk->tampilProduk();
$rekap = $transaksi->rekapTransaksi();

?>

<h1>Dashboard Inventaris</h1>

<a href="tambah_produk.php">
    Tambah Produk
</a>

|

<a href="tambah_transaksi.php">
    Tambah Transaksi
</a>

<br><br>

<h3>Data Produk</h3>

<table border="1" cellpadding="8">

    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
    </tr>

    <?php while($row = $dataProduk->fetch(PDO::FETCH_ASSOC)) { ?>

    <tr>

        <td><?= $row['id']; ?></td>
        <td><?= $row['nama_produk']; ?></td>
        <td><?= $row['kategori']; ?></td>
        <td>Rp <?= number_format($row['harga']); ?></td>
        <td><?= $row['stok']; ?></td>

    </tr>

    <?php } ?>

</table>

<br>

<h3>Rekap Transaksi</h3>

<table border="1" cellpadding="8">

    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Jumlah</th>
        <th>Tanggal</th>
    </tr>

    <?php while($trx = $rekap->fetch(PDO::FETCH_ASSOC)) { ?>

    <tr>

        <td><?= $trx['id']; ?></td>
        <td><?= $trx['nama_produk']; ?></td>
        <td><?= $trx['jumlah']; ?></td>
        <td><?= $trx['tanggal']; ?></td>

    </tr>

    <?php } ?>

</table>

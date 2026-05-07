<?php

require_once __DIR__ . '/../config/database.php';

class Transaksi extends Database {

    public $conn;

    public function __construct() {

        $this->conn = $this->getConnection();
    }

    // Proses transaksi
    public function transaksi(
        $produk_id,
        $jumlah
    ) {

        // Ambil stok produk
        $cek = $this->conn->prepare(
            "SELECT stok
             FROM produk
             WHERE id = :id"
        );

        $cek->bindParam(':id', $produk_id);

        $cek->execute();

        $data = $cek->fetch(PDO::FETCH_ASSOC);

        $stok = $data['stok'];

        // Validasi stok
        if ($jumlah > $stok) {

            echo "Stok tidak mencukupi.";

            return false;
        }

        // Hitung stok baru
        $stokBaru = $stok - $jumlah;

        // Update stok produk
        $update = $this->conn->prepare(
            "UPDATE produk
             SET stok = :stok
             WHERE id = :id"
        );

        $update->bindParam(':stok', $stokBaru);
        $update->bindParam(':id', $produk_id);

        $update->execute();

        // Simpan transaksi
        $sql = $this->conn->prepare(
            "INSERT INTO transaksi
             (produk_id, jumlah)

             VALUES
             (:produk_id, :jumlah)"
        );

        $sql->bindParam(':produk_id', $produk_id);
        $sql->bindParam(':jumlah', $jumlah);

        return $sql->execute();
    }

    // Rekap transaksi
    public function rekapTransaksi() {

        $sql = "SELECT
                    t.id,
                    p.nama,
                    t.jumlah,
                    t.tanggal

                FROM transaksi t

                JOIN produk p
                ON t.produk_id = p.id";

        return $this->conn->query($sql);
    }
}

?>
<?php

require_once __DIR__ . '/../config/database.php';

class Transaksi extends Database {
    public $conn;

    public function __construct() {
        $this->conn = $this->getConnection();
    }

    public function transaksi(
        $produk_id,
        $jumlah
    ) {
        
        $cek = $this->conn->prepare(
            "SELECT stok
             FROM produk
             WHERE id = :id"
        );

        $cek->bindParam(':id', $produk_id);
        $cek->execute();
        $data = $cek->fetch(PDO::FETCH_ASSOC);
        $stok = $data['stok'];

        if ($jumlah > $stok) {
            echo "Stok tidak mencukupi.";
            return false;
        }

        $stokBaru = $stok - $jumlah;
        $update = $this->conn->prepare(
            "UPDATE produk
             SET stok = :stok
             WHERE id = :id"
        );

        $update->bindParam(':stok', $stokBaru);
        $update->bindParam(':id', $produk_id);

        $update->execute();

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

    public function rekapTransaksi() {
        $sql = "SELECT
                    t.id,
                    p.nama_produk,
                    t.jumlah,
                    t.tanggal

                FROM transaksi t

                JOIN produk p
                ON t.produk_id = p.id";

        return $this->conn->query($sql);
    }
}

?>

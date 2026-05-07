<?php

require_once __DIR__ . '/../config/database.php';

class Produk extends Database {
    public $conn;
    public function __construct() {
        $this->conn = $this->getConnection();
    }

    public function tampilProduk() {
        $sql = "SELECT * FROM produk";
        return $this->conn->query($sql);
    }

    public function updateStok(
        $id,
        $stokBaru
    ) {

        if ($stokBaru < 0) {
            echo "Stok tidak boleh negatif.";
            return false;
        }

        $sql = "UPDATE produk
                SET stok = :stok
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':stok', $stokBaru);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function cekStokMenipis() {
        $sql = "SELECT * FROM produk
                WHERE stok < 5";

        return $this->conn->query($sql);
    }
}

?>
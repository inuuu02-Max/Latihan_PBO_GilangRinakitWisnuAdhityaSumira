<?php
require_once 'Tiket.php';

class TiketVelvet extends Tiket {
    // Properti tambahan terenkapsulasi khusus Tiket Velvet
    private $bantal_selimut;
    private $layanan_butler;

    // Constructor Overriding
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar, $bantal_selimut, $layanan_butler) {
        // Memanggil constructor dari abstract class induk (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar);
        $this->bantal_selimut = $bantal_selimut;
        $this->layanan_butler = $layanan_butler;
    }

    // Getter untuk Enkapsulasi
    public function getBantalSelimut() { return $this->bantal_selimut; }
    public function getLayananButler() { return $this->layanan_butler; }

    // =========================================================================
    // TAHAP 5: IMPLEMENTASI POLIMORFISME (METHOD OVERRIDING)
    // =========================================================================
    public function hitungTotalHarga() {
        // Rumus Soal Tiket Velvet: Dikenakan surcharge/biaya tambahan kelas premium sebesar 50% dari total harga dasar
        // Total Harga = (jumlah_kursi * hargaDasarTiket) * 1.50
        return ($this->jumlah_kursi * $this->harga_dasar) * 1.50;
    }

    // Implementasi menampilkan informasi fasilitas
    public function tampilkanInfoFasilitas() {
        return "Fasilitas Tiket Velvet: Sofa Bed mewah, Fasilitas Kenyamanan: <strong>{$this->bantal_selimut}</strong>, Standby Layanan Butler: <strong>{$this->layanan_butler}</strong>.";
    }
}
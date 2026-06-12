<?php
require_once 'Tiket.php';

class TiketVelvet extends Tiket {
    private $bantal_selimut;
    private $layanan_butler;
    private $service_charge_velvet = 50000; // Biaya tambahan service Velvet

    // Constructor Overriding
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar, $bantal_selimut, $layanan_butler) {
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar);
        $this->bantal_selimut = $bantal_selimut;
        $this->layanan_butler = $layanan_butler;
    }

    // Getter & Setter
    public function getBantalSelimut() { return $this->bantal_selimut; }
    public function getLayananButler() { return $this->layanan_butler; }

    // Implementasi Method Abstrak
    public function hitungTotalHarga() {
        return ($this->harga_dasar * $this->jumlah_kursi) + $this->service_charge_velvet;
    }

    public function tampilkanInfoFasilitas() {
        return "Fasilitas Tiket Velvet: Sofa Bed mewah, Fasilitas Kenyamanan: <strong>{$this->bantal_selimut}</strong>, Standby Layanan Butler: <strong>{$this->layanan_butler}</strong>.";
    }
}
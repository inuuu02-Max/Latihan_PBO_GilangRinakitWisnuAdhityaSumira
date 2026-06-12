<?php
require_once 'Tiket.php';

class TiketIMAX extends Tiket {
    private $kacamata_3d;
    private $efek_gerak;
    private $surcharge_imax = 25000; // Biaya tambahan layar IMAX

    // Constructor Overriding
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar, $kacamata_3d, $efek_gerak) {
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar);
        $this->kacamata_3d = $kacamata_3d;
        $this->efek_gerak = $efek_gerak;
    }

    // Getter & Setter
    public function getKacamata3d() { return $this->kacamata_3d; }
    public function getEfekGerak() { return $this->efek_gerak; }

    // Implementasi Method Abstrak
    public function hitungTotalHarga() {
        return ($this->harga_dasar + $this->surcharge_imax) * $this->jumlah_kursi;
    }

    public function tampilkanInfoFasilitas() {
        return "Fasilitas Tiket IMAX: Layar studio raksasa, Kacamata 3D: <strong>{$this->kacamata_3d}</strong>, Fitur Efek Gerak Kursi: <strong>{$this->efek_gerak}</strong>.";
    }
}
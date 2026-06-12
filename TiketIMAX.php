<?php
require_once 'Tiket.php';

class TiketIMAX extends Tiket {
    // Properti tambahan terenkapsulasi khusus Tiket IMAX
    private $kacamata_3d;
    private $efek_gerak;

    // Constructor Overriding
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar, $kacamata_3d, $efek_gerak) {
        // Memanggil constructor dari abstract class induk (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar);
        $this->kacamata_3d = $kacamata_3d;
        $this->efek_gerak = $efek_gerak;
    }

    // Getter untuk Enkapsulasi
    public function getKacamata3d() { return $this->kacamata_3d; }
    public function getEfekGerak() { return $this->efek_gerak; }

    // =========================================================================
    // TAHAP 5: IMPLEMENTASI POLIMORFISME (METHOD OVERRIDING)
    // =========================================================================
    public function hitungTotalHarga() {
        // Rumus Soal Tiket IMAX: Dikenakan biaya tambahan teknologi proyeksi layar lebar IMAX dan audio flat Rp35.000
        // Total Harga = (jumlah_kursi * hargaDasarTiket) + 35000
        return ($this->jumlah_kursi * $this->harga_dasar) + 35000;
    }

    // Implementasi menampilkan informasi fasilitas
    public function tampilkanInfoFasilitas() {
        return "Fasilitas Tiket IMAX: Layar studio raksasa, Kacamata 3D: <strong>{$this->kacamata_3d}</strong>, Fitur Efek Gerak Kursi: <strong>{$this->efek_gerak}</strong>.";
    }
}
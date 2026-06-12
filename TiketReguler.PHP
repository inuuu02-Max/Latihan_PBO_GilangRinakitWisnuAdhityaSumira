<?php
require_once 'Tiket.php';

class TiketReguler extends Tiket {
    // Properti tambahan terenkapsulasi khusus Tiket Reguler
    private $tipe_audio;
    private $lokasi_baris;

    // Constructor Overriding
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar, $tipe_audio, $lokasi_baris) {
        // Memanggil constructor dari abstract class induk (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar);
        $this->tipe_audio = $tipe_audio;
        $this->lokasi_baris = $lokasi_baris;
    }

    // Getter untuk Enkapsulasi
    public function getTipeAudio() { return $this->tipe_audio; }
    public function getLokasiBaris() { return $this->lokasi_baris; }

    // =========================================================================
    // TAHAP 5: IMPLEMENTASI POLIMORFISME (METHOD OVERRIDING)
    // =========================================================================
    public function hitungTotalHarga() {
        // Rumus Soal Tiket Reguler: Tarif standar murni tanpa biaya tambahan fasilitas
        // Total Harga = jumlah_kursi * hargaDasarTiket
        return $this->jumlah_kursi * $this->harga_dasar;
    }

    // Implementasi menampilkan informasi fasilitas
    public function tampilkanInfoFasilitas() {
        return "Fasilitas Tiket Reguler: Kursi standar ergonomis, Tipe Audio: <strong>{$this->tipe_audio}</strong>, Berada di lokasi baris: <strong>{$this->lokasi_baris}</strong>.";
    }
}
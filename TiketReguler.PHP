<?php
require_once 'Tiket.php';

class TiketReguler extends Tiket {
    private $tipe_audio;
    private $lokasi_baris;
    private $biaya_layanan = 3000;

    // Constructor Overriding
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar, $tipe_audio, $lokasi_baris) {
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar);
        $this->tipe_audio = $tipe_audio;
        $this->lokasi_baris = $lokasi_baris;
    }

    // Getter & Setter
    public function getTipeAudio() { return $this->tipe_audio; }
    public function getLokasiBaris() { return $this->lokasi_baris; }

    // Implementasi Method Abstrak
    public function hitungTotalHarga() {
        return ($this->harga_dasar * $this->jumlah_kursi) + $this->biaya_layanan;
    }

    public function tampilkanInfoFasilitas() {
        return "Fasilitas Tiket Reguler: Kursi standar ergonomis, Tipe Audio: <strong>{$this->tipe_audio}</strong>, Berada di lokasi baris: <strong>{$this->lokasi_baris}</strong>.";
    }
}
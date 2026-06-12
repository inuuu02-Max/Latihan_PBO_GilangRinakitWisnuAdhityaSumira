<?php

abstract class Tiket {
    // Properti terenkapsulasi (dipetakan dari kolom tabel database)
    protected $id_tiket;
    protected $nama_film;
    protected $jadwal_tayang;
    protected $jumlah_kursi;
    protected $harga_dasar;

    // Constructor untuk menginisialisasi properti saat objek dibuat (atau saat mengambil data dari DB)
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $harga_dasar) {
        $this->id_tiket = $id_tiket;
        $this->nama_film = $nama_film;
        $this->jadwal_tayang = $jadwal_tayang;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->harga_dasar = $harga_dasar;
    }

    // Getter dan Setter untuk Enkapsulasi (Akses properti yang dilindungi)
    public function getIdTiket() { return $this->id_tiket; }
    public function setIdTiket($id_tiket) { $this->id_tiket = $id_tiket; }

    public function getNamaFilm() { return $this->nama_film; }
    public function setNamaFilm($nama_film) { $this->nama_film = $nama_film; }

    public function getJadwalTayang() { return $this->jadwal_tayang; }
    public function setJadwalTayang($jadwal_tayang) { $this->jadwal_tayang = $jadwal_tayang; }

    public function getJumlahKursi() { return $this->jumlah_kursi; }
    public function setJumlahKursi($jumlah_kursi) { $this->jumlah_kursi = $jumlah_kursi; }

    public function getHargaDasar() { return $this->harga_dasar; }
    public function setHargaDasar($harga_dasar) { $this->harga_dasar = $harga_dasar; }


    // === ABSTRACT METHODS (Wajib diimplementasikan di kelas turunan) ===
    
    // Metode abstrak tanpa isi untuk menghitung total harga
    abstract public function hitungTotalHarga();

    // Metode abstrak tanpa isi untuk menampilkan informasi fasilitas tiket
    abstract public function tampilkanInfoFasilitas();
}
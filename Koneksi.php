<?php

// Konfigurasi Database
$host     = "localhost";
$username = "root";
$password = ""; // Kosongkan jika menggunakan XAMPP bawaan
$database = "db_bioskop"; // Sesuaikan dengan nama database Tahap 1 kamu

// Membuat koneksi ke database menggunakan MySQLi (Pendekatan Objek)
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil atau gagal
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Set charset ke UTF-8 agar mendukung pembacaan karakter yang aman
$koneksi->set_charset("utf8");

// Catatan: Variabel $koneksi ini yang akan dipanggil di file lain untuk query ke database.
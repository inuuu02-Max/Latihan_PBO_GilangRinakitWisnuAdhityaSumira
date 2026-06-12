<?php
// Konfigurasi Koneksi Database
$host     = "localhost";
$username = "root";
$password = ""; 
// KOREKSI DI SINI: Pastikan namanya persis nama database latihanmu yang ada tabel_tiket-nya
$database = "db_latihan_pbo_trpl1a_gilangrinakitwisnuadhityasumirat"; 

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

$koneksi->set_charset("utf8");
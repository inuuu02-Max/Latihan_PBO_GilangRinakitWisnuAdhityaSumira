<?php
// Mengimport semua file komponen yang dibutuhkan
require_once 'Koneksi.php'; // Pastikan huruf kapital K-nya sesuai nama filemu (Koneksi.php atau koneksi.php)
require_once 'TiketReguler.php';
require_once 'TiketIMAX.php';
require_once 'TiketVelvet.php';

// =========================================================================
// AMBIL DATA DINAMIS DARI DATABASE (SUDAH DISUAIKAN DENGAN FOTO KAMU)
// =========================================================================

$query = "SELECT * FROM tabel_tiket";
$result = $koneksi->query($query);

$daftar_reguler = [];
$daftar_imax    = [];
$daftar_velvet  = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        // Membaca kolom 'jenis_studio' sesuai dengan isi ENUM di database kamu
        $studio = strtolower($row['jenis_studio']);

        if ($studio == 'regular' || $studio == 'reguler') {
            $daftar_reguler[] = new TiketReguler(
                $row['id_tiket'], 
                $row['nama_film'], 
                $row['jadwal_tayang'], 
                $row['jumlah_kursi'], 
                $row['harga_dasar_tiket'], // Sesuai kolom database kamu
                $row['tipe_audio'], 
                $row['lokasi_baris']
            );
        } 
        elseif ($studio == 'imax') {
            $daftar_imax[] = new TiketIMAX(
                $row['id_tiket'], 
                $row['nama_film'], 
                $row['jadwal_tayang'], 
                $row['jumlah_kursi'], 
                $row['harga_dasar_tiket'], // Sesuai kolom database kamu
                $row['kacamata_3d_id'],    // Sesuai kolom database kamu
                $row['efek_gerak_fitur']   // Sesuai kolom database kamu
            );
        } 
        elseif ($studio == 'velvet') {
            $daftar_velvet[] = new TiketVelvet(
                $row['id_tiket'], 
                $row['nama_film'], 
                $row['jadwal_tayang'], 
                $row['jumlah_kursi'], 
                $row['harga_dasar_tiket'], // Sesuai kolom database kamu
                $row['bantal_selimut_pack'],// Sesuai kolom database kamu
                $row['layanan_sub_butler']  // SAKTI: Sudah disesuaikan dengan foto 'layanan_sub_butler'
            );
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Antarmuka Daftar Tiket Penonton - Tahap 6</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; padding: 30px; }
        .container { max-width: 1100px; margin: 0 auto; }
        h1 { text-align: center; margin-bottom: 40px; color: #222; }
        .section-title { background: #343a40; color: #fff; padding: 12px 20px; border-radius: 6px; font-size: 20px; margin-top: 30px; margin-bottom: 15px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
        .card { background: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; }
        .card-header { font-size: 18px; font-weight: bold; margin-bottom: 10px; border-bottom: 2px solid #eee; padding-bottom: 8px; color: #495057; }
        .info-row { margin: 6px 0; font-size: 14px; }
        .info-row strong { color: #555; }
        .fasilitas-box { background: #f1f3f5; padding: 10px; border-radius: 6px; margin-top: 10px; font-size: 13px; line-height: 1.4; border-left: 4px solid #adb5bd; }
        .price-box { margin-top: 15px; padding-top: 10px; border-top: 1px dashed #dee2e6; text-align: right; font-size: 18px; font-weight: bold; color: #d9534f; }
        .color-reguler { border-top: 5px solid #007bff; }
        .color-imax { border-top: 5px solid #ffc107; }
        .color-velvet { border-top: 5px solid #28a745; }
        .empty-message { padding: 20px; background: #fff; border: 1px dashed #ccc; border-radius: 6px; color: #777; }
    </style>
</head>
<body>

<div class="container">
    <h1>Daftar Tiket Pemesanan Penonton (View Dinamis)</h1>

    <div class="section-title">Kategori: Studio Regular</div>
    <div class="grid">
        <?php if (empty($daftar_reguler)): ?>
            <div class="empty-message">Belum ada data pemesanan untuk Studio Regular.</div>
        <?php else: ?>
            <?php foreach ($daftar_reguler as $tiket): ?>
                <div class="card color-reguler">
                    <div>
                        <div class="card-header">ID TIKET: #<?php echo $tiket->getIdTiket(); ?></div>
                        <div class="info-row"><strong>Film:</strong> <?php echo $tiket->getNamaFilm(); ?></div>
                        <div class="info-row"><strong>Jadwal Tayang:</strong> <?php echo $tiket->getJadwalTayang(); ?></div>
                        <div class="info-row"><strong>Jumlah Kursi:</strong> <?php echo $tiket->getJumlahKursi(); ?> Kursi</div>
                        <div class="info-row"><strong>Harga Dasar:</strong> Rp <?php echo number_format($tiket->getHargaDasar(), 0, ',', '.'); ?></div>
                        <div class="fasilitas-box">
                            <?php echo $tiket->tampilkanInfoFasilitas(); ?>
                        </div>
                    </div>
                    <div class="price-box">
                        Total Harga: Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="section-title">Kategori: Studio IMAX</div>
    <div class="grid">
        <?php if (empty($daftar_imax)): ?>
            <div class="empty-message">Belum ada data pemesanan untuk Studio IMAX.</div>
        <?php else: ?>
            <?php foreach ($daftar_imax as $tiket): ?>
                <div class="card color-imax">
                    <div>
                        <div class="card-header">ID TIKET: #<?php echo $tiket->getIdTiket(); ?></div>
                        <div class="info-row"><strong>Film:</strong> <?php echo $tiket->getNamaFilm(); ?></div>
                        <div class="info-row"><strong>Jadwal Tayang:</strong> <?php echo $tiket->getJadwalTayang(); ?></div>
                        <div class="info-row"><strong>Jumlah Kursi:</strong> <?php echo $tiket->getJumlahKursi(); ?> Kursi</div>
                        <div class="info-row"><strong>Harga Dasar:</strong> Rp <?php echo number_format($tiket->getHargaDasar(), 0, ',', '.'); ?></div>
                        <div class="fasilitas-box">
                            <?php echo $tiket->tampilkanInfoFasilitas(); ?>
                        </div>
                    </div>
                    <div class="price-box">
                        Total Harga: Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="section-title">Kategori: Studio Velvet</div>
    <div class="grid">
        <?php if (empty($daftar_velvet)): ?>
            <div class="empty-message">Belum ada data pemesanan untuk Studio Velvet.</div>
        <?php else: ?>
            <?php foreach ($daftar_velvet as $tiket): ?>
                <div class="card color-velvet">
                    <div>
                        <div class="card-header">ID TIKET: #<?php echo $tiket->getIdTiket(); ?></div>
                        <div class="info-row"><strong>Film:</strong> <?php echo $tiket->getNamaFilm(); ?></div>
                        <div class="info-row"><strong>Jadwal Tayang:</strong> <?php echo $tiket->getJadwalTayang(); ?></div>
                        <div class="info-row"><strong>Jumlah Kursi:</strong> <?php echo $tiket->getJumlahKursi(); ?> Kursi</div>
                        <div class="info-row"><strong>Harga Dasar:</strong> Rp <?php echo number_format($tiket->getHargaDasar(), 0, ',', '.'); ?></div>
                        <div class="fasilitas-box">
                            <?php echo $tiket->tampilkanInfoFasilitas(); ?>
                        </div>
                    </div>
                    <div class="price-box">
                        Total Harga: Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
<?php
// Mengimport semua file komponen yang dibutuhkan
require_once 'Koneksi.php'; 
require_once 'TiketReguler.php';
require_once 'TiketIMAX.php';
require_once 'TiketVelvet.php';

// =========================================================================
// AMBIL DATA DINAMIS DARI DATABASE
// =========================================================================
$query = "SELECT * FROM tabel_tiket";
$result = $koneksi->query($query);

$daftar_reguler = [];
$daftar_imax    = [];
$daftar_velvet  = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        $studio = strtolower($row['jenis_studio']);

        if ($studio == 'regular' || $studio == 'reguler') {
            $daftar_reguler[] = new TiketReguler(
                $row['id_tiket'], 
                $row['nama_film'], 
                $row['jadwal_tayang'], 
                $row['jumlah_kursi'], 
                $row['harga_dasar_tiket'], 
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
                $row['harga_dasar_tiket'], 
                $row['kacamata_3d_id'],    
                $row['efek_gerak_fitur']   
            );
        } 
        elseif ($studio == 'velvet') {
            $daftar_velvet[] = new TiketVelvet(
                $row['id_tiket'], 
                $row['nama_film'], 
                $row['jadwal_tayang'], 
                $row['jumlah_kursi'], 
                $row['harga_dasar_tiket'], 
                $row['bantal_selimut_pack'],
                $row['layanan_sub_butler']  
            );
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cineplex Dashboard - Manajemen Tiket</title>
    <style>
        :root {
            --bg-dark: #0f111a;
            --bg-card: #1a1d29;
            --text-light: #f8f9fa;
            --text-muted: #a0aec0;
            --primary-gold: #e5a93b;
            --brand-blue: #007bff;
            --brand-green: #2ecc71;
        }

        body { 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            background-color: var(--bg-dark); 
            color: var(--text-light); 
            margin: 0; 
            padding: 0;
        }

        /* Header Style */
        header {
            background: linear-gradient(180deg, rgba(26,29,41,1) 0%, rgba(15,17,26,1) 100%);
            padding: 30px 50px;
            border-bottom: 1px solid #222533;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            background: linear-gradient(45deg, #fff, var(--primary-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        header p {
            margin: 5px 0 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .badge-live {
            background-color: #27ae60;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-live::before {
            content: '';
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50px;
            display: inline-block;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.9); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.5; }
        }

        .container { 
            max-width: 1300px; 
            margin: 0 auto; 
            padding: 40px 20px;
        }

        /* Section Category Titles */
        .section-header {
            display: flex;
            align-items: center;
            margin-top: 40px;
            margin-bottom: 20px;
            gap: 15px;
        }

        .section-title { 
            font-size: 22px; 
            font-weight: 600; 
            letter-spacing: 0.5px;
            margin: 0;
        }

        .line-decorator {
            flex-grow: 1;
            height: 1px;
            background: linear-gradient(90deg, #222533, transparent);
        }

        /* Grid Layout */
        .grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); 
            gap: 25px; 
        }

        /* Premium Card Design */
        .card { 
            background: var(--bg-card); 
            border: 1px solid #262938; 
            border-radius: 14px; 
            padding: 24px; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            display: flex; 
            flex-direction: column; 
            justify-content: space-between;
            transition: transform 0.3s ease, border-color 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Border Glow Per Category */
        .studio-regular { border-left: 4px solid var(--brand-blue); }
        .studio-regular:hover { border-color: var(--brand-blue); }
        .tag-regular { background: rgba(0, 123, 255, 0.15); color: #3b9eff; }

        .studio-imax { border-left: 4px solid var(--primary-gold); }
        .studio-imax:hover { border-color: var(--primary-gold); }
        .tag-imax { background: rgba(229, 169, 59, 0.15); color: var(--primary-gold); }

        .studio-velvet { border-left: 4px solid var(--brand-green); }
        .studio-velvet:hover { border-color: var(--brand-green); }
        .tag-velvet { background: rgba(46, 204, 113, 0.15); color: var(--brand-green); }

        .card-header-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .ticket-id {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            background: #252836;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .studio-tag {
            font-size: 11px;
            font-weight: bold;
            padding: 4px 10px;
            border-radius: 50px;
            text-transform: uppercase;
        }

        .movie-title {
            font-size: 22px;
            font-weight: bold;
            margin: 0 0 15px 0;
            color: #fff;
            line-height: 1.2;
        }

        .info-row { 
            margin: 8px 0; 
            font-size: 14px; 
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #222533;
            padding-bottom: 6px;
        }

        .info-row span { color: var(--text-muted); }
        .info-row strong { color: #e2e8f0; font-weight: 500; }

        /* Custom Box Fasilitas Objek Unik */
        .fasilitas-box { 
            background: #141622; 
            padding: 12px 15px; 
            border-radius: 10px; 
            margin-top: 15px; 
            font-size: 13px; 
            line-height: 1.5; 
            color: #cbd5e0;
            border: 1px solid #222533;
        }
        
        .fasilitas-box strong {
            color: #fff;
        }

        /* Price Box Footer */
        .price-box { 
            margin-top: 20px; 
            padding-top: 15px; 
            border-top: 1px solid #262938; 
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-box span {
            font-size: 13px;
            color: var(--text-muted);
        }

        .total-price {
            font-size: 20px; 
            font-weight: 700; 
            color: #ff4757; 
        }

        .empty-message { 
            grid-column: 1 / -1;
            padding: 30px; 
            background: var(--bg-card); 
            border: 1px dashed #333; 
            border-radius: 10px; 
            color: var(--text-muted); 
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>

<header>
    <div>
        <h1>CINEPLEX DASHBOARD</h1>
        <p>Sistem Pemantauan Kelas & Fasilitas Tiket Studio Finansial</p>
    </div>
    <div class="badge-live">Database Terkoneksi Dinamis</div>
</header>

<div class="container">

    <div class="section-header">
        <h2 class="section-title" style="color: var(--brand-blue);">Studio Regular</h2>
        <div class="line-decorator"></div>
    </div>
    <div class="grid">
        <?php if (empty($daftar_reguler)): ?>
            <div class="empty-message">Tidak ada data transaksi pemesanan di Studio Regular.</div>
        <?php else: ?>
            <?php foreach ($daftar_reguler as $tiket): ?>
                <div class="card studio-regular">
                    <div>
                        <div class="card-header-area">
                            <span class="ticket-id">ID: #<?php echo $tiket->getIdTiket(); ?></span>
                            <span class="studio-tag tag-regular">Regular Class</span>
                        </div>
                        <h3 class="movie-title"><?php echo $tiket->getNamaFilm(); ?></h3>
                        
                        <div class="info-row"><span>Jadwal Tayang</span><strong><?php echo date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</strong></div>
                        <div class="info-row"><span>Jumlah Kursi</span><strong><?php echo $tiket->getJumlahKursi(); ?> Ticket</strong></div>
                        <div class="info-row"><span>Harga Satuan</span><strong>Rp <?php echo number_format($tiket->getHargaDasar(), 0, ',', '.'); ?></strong></div>
                        
                        <div class="fasilitas-box">
                            <?php echo $tiket->tampilkanInfoFasilitas(); ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span>Total Pembayaran</span>
                        <div class="total-price">Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="section-header">
        <h2 class="section-title" style="color: var(--primary-gold);">Studio IMAX</h2>
        <div class="line-decorator"></div>
    </div>
    <div class="grid">
        <?php if (empty($daftar_imax)): ?>
            <div class="empty-message">Tidak ada data transaksi pemesanan di Studio IMAX.</div>
        <?php else: ?>
            <?php foreach ($daftar_imax as $tiket): ?>
                <div class="card studio-imax">
                    <div>
                        <div class="card-header-area">
                            <span class="ticket-id">ID: #<?php echo $tiket->getIdTiket(); ?></span>
                            <span class="studio-tag tag-imax">IMAX 3D</span>
                        </div>
                        <h3 class="movie-title"><?php echo $tiket->getNamaFilm(); ?></h3>
                        
                        <div class="info-row"><span>Jadwal Tayang</span><strong><?php echo date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</strong></div>
                        <div class="info-row"><span>Jumlah Kursi</span><strong><?php echo $tiket->getJumlahKursi(); ?> Ticket</strong></div>
                        <div class="info-row"><span>Harga Satuan</span><strong>Rp <?php echo number_format($tiket->getHargaDasar(), 0, ',', '.'); ?></strong></div>
                        
                        <div class="fasilitas-box">
                            <?php echo $tiket->tampilkanInfoFasilitas(); ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span>Total Pembayaran</span>
                        <div class="total-price">Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="section-header">
        <h2 class="section-title" style="color: var(--brand-green);">Studio Velvet</h2>
        <div class="line-decorator"></div>
    </div>
    <div class="grid">
        <?php if (empty($daftar_velvet)): ?>
            <div class="empty-message">Tidak ada data transaksi pemesanan di Studio Velvet.</div>
        <?php else: ?>
            <?php foreach ($daftar_velvet as $tiket): ?>
                <div class="card studio-velvet">
                    <div>
                        <div class="card-header-area">
                            <span class="ticket-id">ID: #<?php echo $tiket->getIdTiket(); ?></span>
                            <span class="studio-tag tag-velvet">Velvet Luxury</span>
                        </div>
                        <h3 class="movie-title"><?php echo $tiket->getNamaFilm(); ?></h3>
                        
                        <div class="info-row"><span>Jadwal Tayang</span><strong><?php echo date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</strong></div>
                        <div class="info-row"><span>Jumlah Kursi</span><strong><?php echo $tiket->getJumlahKursi(); ?> Ticket</strong></div>
                        <div class="info-row"><span>Harga Satuan</span><strong>Rp <?php echo number_format($tiket->getHargaDasar(), 0, ',', '.'); ?></strong></div>
                        
                        <div class="fasilitas-box">
                            <?php echo $tiket->tampilkanInfoFasilitas(); ?>
                        </div>
                    </div>
                    <div class="price-box">
                        <span>Total Pembayaran</span>
                        <div class="total-price">Rp <?php echo number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
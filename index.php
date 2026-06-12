<?php
require_once 'Koneksi.php';
require_once 'TiketReguler.php';
require_once 'TiketIMAX.php';
require_once 'TiketVelvet.php';

$query  = "SELECT * FROM tabel_tiket";
$result = $koneksi->query($query);

$daftar_reguler = [];
$daftar_imax    = [];
$daftar_velvet  = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $studio = strtolower($row['jenis_studio']);
        if ($studio === 'regular' || $studio === 'reguler') {
            $daftar_reguler[] = new TiketReguler(
                $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'],
                $row['jumlah_kursi'], $row['harga_dasar_tiket'],
                $row['tipe_audio'], $row['lokasi_baris']
            );
        } elseif ($studio === 'imax') {
            $daftar_imax[] = new TiketIMAX(
                $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'],
                $row['jumlah_kursi'], $row['harga_dasar_tiket'],
                $row['kacamata_3d_id'], $row['efek_gerak_fitur']
            );
        } elseif ($studio === 'velvet') {
            $daftar_velvet[] = new TiketVelvet(
                $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'],
                $row['jumlah_kursi'], $row['harga_dasar_tiket'],
                $row['bantal_selimut_pack'], $row['layanan_sub_butler']
            );
        }
    }
}

// ===== Statistik untuk header =====
$totalTiket   = count($daftar_reguler) + count($daftar_imax) + count($daftar_velvet);
$totalKursi   = 0;
$totalRevenue = 0;
foreach ([$daftar_reguler, $daftar_imax, $daftar_velvet] as $list) {
    foreach ($list as $t) {
        $totalKursi   += (int) $t->getJumlahKursi();
        $totalRevenue += (float) $t->hitungTotalHarga();
    }
}

function renderCard($tiket, $studio, $label, $icon) { ?>
    <article class="card card-<?= $studio ?>">
        <div class="card-glow"></div>
        <div class="card-perforation left"></div>
        <div class="card-perforation right"></div>

        <div class="card-top">
            <div class="card-badge badge-<?= $studio ?>">
                <span class="badge-icon"><?= $icon ?></span>
                <?= $label ?>
            </div>
            <span class="card-id">#<?= htmlspecialchars($tiket->getIdTiket()) ?></span>
        </div>

        <h3 class="card-title"><?= htmlspecialchars($tiket->getNamaFilm()) ?></h3>

        <div class="card-meta">
            <div class="meta-item">
                <span class="meta-label">Showtime</span>
                <span class="meta-value"><?= date('d M Y', strtotime($tiket->getJadwalTayang())) ?></span>
                <span class="meta-sub"><?= date('H:i', strtotime($tiket->getJadwalTayang())) ?> WIB</span>
            </div>
            <div class="meta-divider"></div>
            <div class="meta-item">
                <span class="meta-label">Seats</span>
                <span class="meta-value"><?= (int) $tiket->getJumlahKursi() ?>×</span>
                <span class="meta-sub">@ Rp <?= number_format($tiket->getHargaDasar(), 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="facility">
            <div class="facility-label">Facility & Add-ons</div>
            <div class="facility-body">
                <?php $tiket->tampilkanInfoFasilitas(); ?>
            </div>
        </div>

        <div class="card-footer">
            <div>
                <div class="total-label">Total Pembayaran</div>
                <div class="total-value">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.') ?></div>
            </div>
            <button class="ticket-btn" type="button">
                <span>PRINT</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
            </button>
        </div>
    </article>
<?php }

function renderSection($title, $subtitle, $studio, $color, $label, $icon, $list) { ?>
    <section class="section">
        <div class="section-head">
            <div class="section-marker" style="background: <?= $color ?>;"></div>
            <div>
                <h2 class="section-title"><?= $title ?></h2>
                <p class="section-sub"><?= $subtitle ?></p>
            </div>
            <div class="section-count"><?= count($list) ?> Tiket</div>
        </div>
        <div class="grid">
            <?php if (empty($list)): ?>
                <div class="empty">
                    <div class="empty-icon">🎬</div>
                    <div class="empty-title">Belum ada pemesanan</div>
                    <div class="empty-sub">Tiket pada studio ini belum tersedia di database.</div>
                </div>
            <?php else: foreach ($list as $t) renderCard($t, $studio, $label, $icon); endif; ?>
        </div>
    </section>
<?php } ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CINEPLEX — Premium Ticket Operations</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
<style>
:root{
  --bg:#07080d;
  --bg-2:#0d0f17;
  --surface:#11141d;
  --surface-2:#171a26;
  --border:rgba(255,255,255,.06);
  --border-strong:rgba(255,255,255,.12);
  --text:#f4f5f7;
  --muted:#8a8f9e;
  --gold:#e8b65a;
  --gold-soft:#f5d68a;
  --blue:#5b8def;
  --green:#3ddc84;
  --red:#ff5470;
  --grad-gold:linear-gradient(135deg,#f5d68a 0%,#e8b65a 50%,#a87b2a 100%);
}
*{box-sizing:border-box;margin:0;padding:0}
html,body{background:var(--bg);color:var(--text);font-family:'Inter',sans-serif;-webkit-font-smoothing:antialiased}
body{
  background:
    radial-gradient(900px 500px at 85% -10%, rgba(232,182,90,.10), transparent 60%),
    radial-gradient(700px 500px at -10% 30%, rgba(91,141,239,.08), transparent 60%),
    radial-gradient(800px 600px at 50% 110%, rgba(61,220,132,.06), transparent 60%),
    var(--bg);
  min-height:100vh;
}
.mono{font-family:'JetBrains Mono',monospace}

/* ============ NAV ============ */
.nav{
  position:sticky;top:0;z-index:50;
  backdrop-filter:blur(20px);
  background:rgba(7,8,13,.7);
  border-bottom:1px solid var(--border);
}
.nav-inner{
  max-width:1400px;margin:0 auto;
  padding:18px 32px;display:flex;align-items:center;justify-content:space-between;
}
.brand{display:flex;align-items:center;gap:12px}
.brand-mark{
  width:40px;height:40px;border-radius:10px;
  background:var(--grad-gold);
  display:grid;place-items:center;
  font-family:'Bebas Neue';font-size:22px;color:#0b0c10;
  box-shadow:0 6px 24px rgba(232,182,90,.35);
}
.brand-name{font-family:'Bebas Neue';font-size:24px;letter-spacing:3px}
.brand-name span{color:var(--gold)}
.nav-meta{display:flex;align-items:center;gap:18px;font-size:13px;color:var(--muted)}
.dot{width:8px;height:8px;border-radius:50%;background:var(--green);box-shadow:0 0 0 4px rgba(61,220,132,.18);animation:pulse 1.8s infinite}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(61,220,132,.4)}50%{box-shadow:0 0 0 8px rgba(61,220,132,0)}}

/* ============ HERO ============ */
.hero{
  max-width:1400px;margin:0 auto;
  padding:60px 32px 30px;
  display:grid;grid-template-columns:1.4fr 1fr;gap:40px;align-items:end;
}
.hero-eyebrow{
  display:inline-flex;align-items:center;gap:10px;
  font-family:'JetBrains Mono';font-size:11px;letter-spacing:2px;
  color:var(--gold);text-transform:uppercase;
  padding:6px 14px;border:1px solid rgba(232,182,90,.3);
  border-radius:50px;background:rgba(232,182,90,.05);
}
.hero h1{
  font-family:'Bebas Neue';
  font-size:clamp(56px,7vw,104px);
  line-height:.95;letter-spacing:1px;
  margin:18px 0;
}
.hero h1 .accent{
  background:var(--grad-gold);
  -webkit-background-clip:text;background-clip:text;color:transparent;
  font-style:italic;
}
.hero p{color:var(--muted);font-size:16px;max-width:520px;line-height:1.6}

/* Stats */
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.stat{
  background:linear-gradient(180deg,var(--surface),var(--bg-2));
  border:1px solid var(--border);border-radius:16px;
  padding:20px;position:relative;overflow:hidden;
}
.stat::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(232,182,90,.08),transparent 50%);
  pointer-events:none;
}
.stat-label{font-size:11px;letter-spacing:1.5px;color:var(--muted);text-transform:uppercase;font-family:'JetBrains Mono'}
.stat-value{font-family:'Bebas Neue';font-size:42px;margin-top:8px;letter-spacing:1px}
.stat:nth-child(1) .stat-value{color:var(--gold)}
.stat:nth-child(2) .stat-value{color:var(--blue)}
.stat:nth-child(3) .stat-value{color:var(--green)}

/* ============ MAIN ============ */
.main{max-width:1400px;margin:0 auto;padding:40px 32px 80px}
.section{margin-top:60px}
.section:first-child{margin-top:30px}
.section-head{
  display:flex;align-items:center;gap:18px;
  margin-bottom:28px;padding-bottom:18px;
  border-bottom:1px solid var(--border);
}
.section-marker{width:6px;height:42px;border-radius:4px}
.section-title{font-family:'Bebas Neue';font-size:34px;letter-spacing:2px}
.section-sub{color:var(--muted);font-size:13px;margin-top:2px}
.section-count{
  margin-left:auto;
  font-family:'JetBrains Mono';font-size:12px;color:var(--muted);
  padding:8px 14px;border:1px solid var(--border-strong);border-radius:50px;
  background:var(--surface);
}

/* ============ GRID & CARDS ============ */
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(380px,1fr));gap:24px}

.card{
  position:relative;
  background:linear-gradient(180deg,var(--surface) 0%, var(--bg-2) 100%);
  border:1px solid var(--border);
  border-radius:20px;
  padding:26px;
  overflow:hidden;
  transition:transform .35s cubic-bezier(.2,.8,.2,1), border-color .3s, box-shadow .35s;
  display:flex;flex-direction:column;
}
.card:hover{
  transform:translateY(-6px);
  border-color:var(--border-strong);
  box-shadow:0 30px 60px -25px rgba(0,0,0,.7);
}
.card-glow{
  position:absolute;top:-40%;right:-30%;
  width:300px;height:300px;border-radius:50%;
  filter:blur(80px);opacity:.25;pointer-events:none;
  transition:opacity .4s;
}
.card:hover .card-glow{opacity:.45}
.card-regular .card-glow{background:var(--blue)}
.card-imax .card-glow{background:var(--gold)}
.card-velvet .card-glow{background:var(--green)}

/* ticket perforation */
.card-perforation{
  position:absolute;top:50%;transform:translateY(-50%);
  width:14px;height:14px;border-radius:50%;
  background:var(--bg);border:1px solid var(--border);
}
.card-perforation.left{left:-8px}
.card-perforation.right{right:-8px}

.card-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;position:relative;z-index:2}
.card-badge{
  display:inline-flex;align-items:center;gap:8px;
  font-family:'JetBrains Mono';font-size:11px;font-weight:600;
  letter-spacing:1.5px;text-transform:uppercase;
  padding:7px 12px;border-radius:8px;
}
.badge-icon{font-size:13px}
.badge-regular{background:rgba(91,141,239,.12);color:#7fa6ff;border:1px solid rgba(91,141,239,.25)}
.badge-imax{background:rgba(232,182,90,.12);color:var(--gold-soft);border:1px solid rgba(232,182,90,.3)}
.badge-velvet{background:rgba(61,220,132,.12);color:#7fe9b0;border:1px solid rgba(61,220,132,.25)}
.card-id{font-family:'JetBrains Mono';font-size:12px;color:var(--muted)}

.card-title{
  font-family:'Bebas Neue';font-size:32px;letter-spacing:1.5px;
  line-height:1.05;margin-bottom:22px;position:relative;z-index:2;
}

.card-meta{
  display:flex;align-items:stretch;gap:18px;
  padding:18px 0;margin-bottom:18px;
  border-top:1px dashed var(--border-strong);
  border-bottom:1px dashed var(--border-strong);
  position:relative;z-index:2;
}
.meta-item{flex:1;display:flex;flex-direction:column;gap:4px}
.meta-label{font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);font-family:'JetBrains Mono'}
.meta-value{font-family:'Bebas Neue';font-size:22px;letter-spacing:1px;color:var(--text)}
.meta-sub{font-size:12px;color:var(--muted);font-family:'JetBrains Mono'}
.meta-divider{width:1px;background:var(--border-strong)}

.facility{
  background:rgba(255,255,255,.02);
  border:1px solid var(--border);
  border-radius:12px;
  padding:14px 16px;
  margin-bottom:20px;
  position:relative;z-index:2;
}
.facility-label{
  font-size:10px;letter-spacing:1.5px;text-transform:uppercase;
  color:var(--muted);font-family:'JetBrains Mono';margin-bottom:8px;
}
.facility-body{font-size:13px;line-height:1.6;color:#d2d5dd}
.facility-body strong{color:#fff;font-weight:600}

.card-footer{
  display:flex;justify-content:space-between;align-items:center;
  margin-top:auto;position:relative;z-index:2;
}
.total-label{font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);font-family:'JetBrains Mono'}
.total-value{font-family:'Bebas Neue';font-size:30px;letter-spacing:1px;color:var(--gold);margin-top:2px}

.ticket-btn{
  display:inline-flex;align-items:center;gap:8px;
  background:var(--grad-gold);color:#0b0c10;
  font-family:'JetBrains Mono';font-weight:600;font-size:12px;letter-spacing:2px;
  border:none;padding:12px 18px;border-radius:10px;cursor:pointer;
  transition:transform .2s, box-shadow .25s;
  box-shadow:0 8px 22px -6px rgba(232,182,90,.5);
}
.ticket-btn:hover{transform:translateY(-2px);box-shadow:0 12px 28px -6px rgba(232,182,90,.7)}

/* Empty */
.empty{
  grid-column:1/-1;
  text-align:center;padding:60px 30px;
  border:1px dashed var(--border-strong);
  border-radius:20px;background:rgba(255,255,255,.015);
}
.empty-icon{font-size:46px;margin-bottom:14px;filter:grayscale(.3)}
.empty-title{font-family:'Bebas Neue';font-size:24px;letter-spacing:1.5px}
.empty-sub{color:var(--muted);font-size:13px;margin-top:6px}

/* footer */
.footer{
  max-width:1400px;margin:0 auto;padding:30px 32px 50px;
  border-top:1px solid var(--border);
  display:flex;justify-content:space-between;align-items:center;
  font-family:'JetBrains Mono';font-size:11px;color:var(--muted);
  letter-spacing:1px;text-transform:uppercase;
}

@media (max-width:900px){
  .hero{grid-template-columns:1fr;gap:30px}
  .stats{grid-template-columns:repeat(3,1fr)}
}
@media (max-width:600px){
  .nav-inner,.hero,.main,.footer{padding-left:18px;padding-right:18px}
  .stats{grid-template-columns:1fr}
  .grid{grid-template-columns:1fr}
}
</style>
</head>
<body>

<nav class="nav">
  <div class="nav-inner">
    <div class="brand">
      <div class="brand-mark">C</div>
      <div>
        <div class="brand-name">CINE<span>PLEX</span></div>
        <div style="font-family:'JetBrains Mono';font-size:10px;color:var(--muted);letter-spacing:2px">PREMIUM OPERATIONS · v2.0</div>
      </div>
    </div>
    <div class="nav-meta">
      <span><span class="dot"></span> Database Live</span>
      <span class="mono"><?= date('D, d M Y · H:i') ?></span>
    </div>
  </div>
</nav>

<header class="hero">
  <div>
    <span class="hero-eyebrow">◆ Ticket Operations Dashboard</span>
    <h1>Manajemen Tiket<br><span class="accent">Studio Sinema</span></h1>
    <p>Sistem pemantauan transaksi pemesanan tiket lintas studio Regular, IMAX, dan Velvet — terhubung langsung dengan database operasional.</p>
  </div>
  <div class="stats">
    <div class="stat">
      <div class="stat-label">Total Tiket</div>
      <div class="stat-value"><?= str_pad((string)$totalTiket, 2, '0', STR_PAD_LEFT) ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Total Kursi</div>
      <div class="stat-value"><?= $totalKursi ?></div>
    </div>
    <div class="stat">
      <div class="stat-label">Revenue (Rp)</div>
      <div class="stat-value"><?= number_format($totalRevenue / 1000, 0, ',', '.') ?>K</div>
    </div>
  </div>
</header>

<main class="main">
  <?php
    renderSection('Studio Regular',  'Pengalaman menonton standar dengan kualitas audio premium.', 'regular', '#5b8def', 'Regular Class', '◐', $daftar_reguler);
    renderSection('Studio IMAX',     'Layar raksasa, audio imersif, dan teknologi 3D sinematik.',  'imax',    '#e8b65a', 'IMAX 3D',       '✦', $daftar_imax);
    renderSection('Studio Velvet',   'Kursi mewah, layanan butler, dan kenyamanan kelas atas.',     'velvet',  '#3ddc84', 'Velvet Luxury', '♛', $daftar_velvet);
  ?>
</main>

<footer class="footer">
  <span>© <?= date('Y') ?> Cineplex Systems</span>
  <span>Built with PHP · MySQL · OOP</span>
</footer>

</body>
</html>

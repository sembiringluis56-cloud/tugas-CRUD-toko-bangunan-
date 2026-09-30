<?php
require_once "../includes/auth.php";
require_once "../config/database.php";
$total_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk"))['total'];
$total_kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(DISTINCT kategori) AS total FROM produk"))['total'];
$total_stok = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(stok),0) AS total FROM produk"))['total'];
$admin_layout = true; $page_title = 'Dashboard Admin'; include "../includes/header.php";
?>
<section class="section">
    <div class="container">
        <?php include "../includes/flash.php"; ?>
        <div class="section-head">
            <div><span class="eyebrow">Panel Admin</span><h1 style="font-size:42px;">Dashboard</h1><p class="muted">Selamat datang, <strong><?= htmlspecialchars($_SESSION['admin_nama']); ?></strong>. Kelola katalog Toko Bangunan dari satu tempat.</p></div>
            <a href="tambah.php" class="btn">+ Tambah Produk</a>
        </div>
        <div class="stat-grid">
            <div class="stat-card"><div class="stat-label">Total Produk</div><div class="stat-value"><?= (int)$total_produk; ?></div><div class="muted small">Produk aktif di katalog</div></div>
            <div class="stat-card"><div class="stat-label">Total Kategori</div><div class="stat-value"><?= (int)$total_kategori; ?></div><div class="muted small">Kategori material & perkakas</div></div>
            <div class="stat-card"><div class="stat-label">Total Stok</div><div class="stat-value"><?= (int)$total_stok; ?></div><div class="muted small">Unit tersedia</div></div>
        </div>
        <div class="card" style="margin-top:20px;">
            <h2>Manajemen Produk</h2>
            <p class="muted">CRUD lengkap: tambah, lihat, ubah, hapus, upload gambar, pencarian, filter kategori, pagination, dan notifikasi aksi.</p>
            <div class="form-actions"><a href="produk.php" class="btn">Kelola Produk</a><a href="../index.php" class="btn btn-secondary">Lihat Website</a></div>
        </div>
    </div>
</section>
<?php include "../includes/footer.php"; ?>

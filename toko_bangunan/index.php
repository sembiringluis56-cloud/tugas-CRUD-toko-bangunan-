<?php
require_once "config/database.php";
$query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC LIMIT 6");
$page_title = 'Beranda';
include "includes/header.php";
?>

<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="eyebrow">Material • Perkakas • Renovasi</span>
            <h1>Bangun lebih mudah dengan produk yang tepat.</h1>
            <p class="lead">Toko Bangunan menyediakan bahan dan perlengkapan bangunan untuk kebutuhan rumah, renovasi, hingga proyek harian.</p>
            <div class="hero-actions">
                <a href="produk.php" class="btn">Lihat Katalog</a>
                <a href="tentang.php" class="btn btn-secondary">Tentang Toko</a>
            </div>
        </div>
        <div class="hero-card">
            <div class="building-icon">🏗️</div>
            <h3>Belanja bahan bangunan lebih praktis</h3>
            <p class="muted">Cari produk, lihat detail harga dan stok, lalu gunakan panel admin untuk mengelola katalog.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div><h2>Produk Terbaru</h2><p class="muted">Pilihan material dan perlengkapan yang tersedia.</p></div>
            <a href="produk.php" class="btn btn-secondary">Semua Produk</a>
        </div>
        <div class="grid">
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <article class="card product-card">
                    <?php if ($row['gambar']): ?>
                        <img src="uploads/produk/<?= htmlspecialchars($row['gambar']); ?>" class="product-image" alt="<?= htmlspecialchars($row['nama']); ?>">
                    <?php endif; ?>
                    <div class="product-body">
                        <span class="badge"><?= htmlspecialchars($row['kategori']); ?></span>
                        <h3 style="margin-top:10px;"><?= htmlspecialchars($row['nama']); ?></h3>
                        <p class="muted"><?= htmlspecialchars($row['deskripsi']); ?></p>
                        <div class="price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
                        <p class="small muted">Stok tersedia: <?= (int)$row['stok']; ?></p>
                        <a href="detail.php?id=<?= (int)$row['id']; ?>" class="btn btn-sm">Lihat Detail</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>

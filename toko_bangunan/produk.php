<?php
require_once "config/database.php";
$keyword = trim($_GET['keyword'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');
$kategori_list = [];
$cat_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk ORDER BY kategori ASC");
while ($cat = mysqli_fetch_assoc($cat_result)) { $kategori_list[] = $cat['kategori']; }

$sql = "SELECT * FROM produk WHERE 1=1";
if ($keyword !== '' && $kategori !== '') {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE nama LIKE ? AND kategori = ? ORDER BY id DESC");
    $keyword_param = "%$keyword%";
    mysqli_stmt_bind_param($stmt, 'ss', $keyword_param, $kategori);
} elseif ($keyword !== '') {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE nama LIKE ? ORDER BY id DESC");
    $keyword_param = "%$keyword%";
    mysqli_stmt_bind_param($stmt, 's', $keyword_param);
} elseif ($kategori !== '') {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE kategori = ? ORDER BY id DESC");
    mysqli_stmt_bind_param($stmt, 's', $kategori);
} else {
    $stmt = mysqli_prepare($conn, "SELECT * FROM produk ORDER BY id DESC");
}
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);
$page_title = 'Katalog Produk';
include "includes/header.php";
?>

<section class="section">
    <div class="container">
        <div class="section-head">
            <div><span class="eyebrow">Katalog</span><h1 style="font-size:40px;">Daftar Produk</h1><p class="muted">Temukan bahan dan perlengkapan bangunan berdasarkan nama atau kategori.</p></div>
        </div>
        <div class="card">
            <form method="GET" class="search-grid">
                <div><label for="keyword">Cari produk</label><input id="keyword" type="text" name="keyword" placeholder="Contoh: semen, cat, bor..." value="<?= htmlspecialchars($keyword); ?>"></div>
                <div><label for="kategori">Kategori</label><select id="kategori" name="kategori"><option value="">Semua Kategori</option><?php foreach ($kategori_list as $cat): ?><option value="<?= htmlspecialchars($cat); ?>" <?= $kategori === $cat ? 'selected' : ''; ?>><?= htmlspecialchars($cat); ?></option><?php endforeach; ?></select></div>
                <button type="submit" class="btn">Cari</button>
                <a href="produk.php" class="btn btn-secondary">Reset</a>
            </form>
        </div>
        <div class="grid">
            <?php if (mysqli_num_rows($query) === 0): ?>
                <div class="card empty" style="grid-column:1/-1;">Produk yang dicari belum ditemukan.</div>
            <?php else: while ($row = mysqli_fetch_assoc($query)): ?>
                <article class="card product-card">
                    <?php if ($row['gambar']): ?><img src="uploads/produk/<?= htmlspecialchars($row['gambar']); ?>" class="product-image" alt="<?= htmlspecialchars($row['nama']); ?>"><?php endif; ?>
                    <div class="product-body">
                        <span class="badge"><?= htmlspecialchars($row['kategori']); ?></span>
                        <h3 style="margin-top:10px;"><?= htmlspecialchars($row['nama']); ?></h3>
                        <p class="muted"><?= htmlspecialchars($row['deskripsi']); ?></p>
                        <div class="price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
                        <p class="small muted">Stok: <?= (int)$row['stok']; ?></p>
                        <a href="detail.php?id=<?= (int)$row['id']; ?>" class="btn btn-sm">Lihat Detail</a>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>
<?php include "includes/footer.php"; ?>

<?php
session_start();
require_once "../includes/auth.php";
require_once "../config/database.php";
$keyword = trim($_GET['keyword'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');
$where = [];
$params = [];
$types = '';
if ($keyword !== '') { $safe = mysqli_real_escape_string($conn, $keyword); $where[] = "nama LIKE '%$safe%'"; }
if ($kategori !== '') { $safe = mysqli_real_escape_string($conn, $kategori); $where[] = "kategori = '$safe'"; }
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
$per_page = 5;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $per_page;
$total_data = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk $where_sql"))['total'];
$total_page = max(1, (int)ceil($total_data / $per_page));
if ($page > $total_page) { $page = $total_page; $offset = ($page - 1) * $per_page; }
$query = mysqli_query($conn, "SELECT * FROM produk $where_sql ORDER BY id DESC LIMIT $per_page OFFSET $offset");
$cat_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM produk ORDER BY kategori ASC");
$kategori_list = [];
while ($cat = mysqli_fetch_assoc($cat_result)) { $kategori_list[] = $cat['kategori']; }
$admin_layout = true; $page_title = 'Kelola Produk'; include "../includes/header.php";
?>
<section class="section">
    <div class="container">
        <?php include "../includes/flash.php"; ?>
        <div class="section-head"><div><span class="eyebrow">CRUD Produk</span><h1 style="font-size:42px;">Kelola Produk</h1><p class="muted">Data produk dikelola dari database dan ditampilkan otomatis di katalog publik.</p></div><a href="tambah.php" class="btn">+ Tambah Produk</a></div>
        <div class="card">
            <form method="GET" class="search-grid">
                <div><label>Cari Produk</label><input type="text" name="keyword" placeholder="Nama produk..." value="<?= htmlspecialchars($keyword); ?>"></div>
                <div><label>Kategori</label><select name="kategori"><option value="">Semua Kategori</option><?php foreach($kategori_list as $cat): ?><option value="<?= htmlspecialchars($cat); ?>" <?= $kategori === $cat ? 'selected' : ''; ?>><?= htmlspecialchars($cat); ?></option><?php endforeach; ?></select></div>
                <button type="submit" class="btn">Cari</button><a href="produk.php" class="btn btn-secondary">Reset</a>
            </form>
        </div>
        <div class="card"><div class="table-wrap"><table><thead><tr><th>No</th><th>Gambar</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead><tbody>
        <?php if (mysqli_num_rows($query) === 0): ?><tr><td colspan="7" class="empty">Belum ada data yang sesuai.</td></tr>
        <?php else: $no=$offset+1; while($row=mysqli_fetch_assoc($query)): ?><tr>
            <td><?= $no++; ?></td><td><?php if($row['gambar']): ?><img class="table-thumb" src="../uploads/produk/<?= htmlspecialchars($row['gambar']); ?>" alt=""><?php else: ?>- <?php endif; ?></td>
            <td><strong><?= htmlspecialchars($row['nama']); ?></strong><div class="small muted"><?= htmlspecialchars($row['deskripsi']); ?></div></td>
            <td><span class="badge"><?= htmlspecialchars($row['kategori']); ?></span></td><td>Rp <?= number_format($row['harga'],0,',','.'); ?></td><td><?= (int)$row['stok']; ?></td>
            <td><div class="actions"><a href="edit.php?id=<?= (int)$row['id']; ?>" class="btn btn-warning btn-sm">Edit</a><a href="hapus.php?id=<?= (int)$row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a></div></td>
        </tr><?php endwhile; endif; ?></tbody></table></div></div>
        <?php if ($total_data > 0): ?><div class="pagination"><?php for($i=1;$i<=$total_page;$i++): ?><a class="<?= $i===$page?'active':''; ?>" href="?page=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>&kategori=<?= urlencode($kategori); ?>"><?= $i; ?></a><?php endfor; ?></div><?php endif; ?>
    </div>
</section>
<?php include "../includes/footer.php"; ?>

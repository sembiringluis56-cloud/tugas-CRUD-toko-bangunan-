<?php
session_start();
require_once "../includes/auth.php";
require_once "../config/database.php";
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE id = ? LIMIT 1"); mysqli_stmt_bind_param($stmt,'i',$id); mysqli_stmt_execute($stmt); $produk=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$produk) { http_response_code(404); die("Produk tidak ditemukan."); }
$categories = ['Semen', 'Cat', 'Besi & Baja', 'Keramik', 'Perkakas', 'Pipa & Sanitasi', 'Kayu'];
$admin_layout = true; $page_title = 'Edit Produk'; include "../includes/header.php";
?>
<section class="section"><div class="container"><div class="card">
    <?php include "../includes/flash.php"; ?><span class="eyebrow">Update</span><h1 style="font-size:40px;">Edit Produk</h1><p class="muted">Perbarui data produk yang sudah tersimpan.</p>
    <form action="proses_produk.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="aksi" value="edit"><input type="hidden" name="id" value="<?= (int)$produk['id']; ?>">
        <div class="form-grid">
            <div class="field"><label>Nama Produk</label><input type="text" name="nama" maxlength="100" value="<?= htmlspecialchars($produk['nama']); ?>" required></div>
            <div class="field"><label>Kategori</label><select name="kategori" required><?php foreach($categories as $cat): ?><option value="<?= htmlspecialchars($cat); ?>" <?= $produk['kategori']===$cat?'selected':''; ?>><?= htmlspecialchars($cat); ?></option><?php endforeach; ?></select></div>
            <div class="field full"><label>Deskripsi</label><textarea name="deskripsi" maxlength="500" required><?= htmlspecialchars($produk['deskripsi']); ?></textarea></div>
            <div class="field"><label>Harga (Rp)</label><input type="number" name="harga" min="0" step="0.01" value="<?= htmlspecialchars($produk['harga']); ?>" required></div>
            <div class="field"><label>Stok</label><input type="number" name="stok" min="0" value="<?= (int)$produk['stok']; ?>" required></div>
            <div class="field full"><label>Ganti Gambar</label><input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp"><div class="small muted">Biarkan kosong jika gambar lama tetap digunakan.</div><?php if($produk['gambar']): ?><div style="margin-top:12px;"><img src="../uploads/produk/<?= htmlspecialchars($produk['gambar']); ?>" class="table-thumb" style="width:120px;height:90px;" alt="Gambar saat ini"></div><?php endif; ?></div>
        </div>
        <div class="form-actions"><button type="submit" class="btn">Simpan Perubahan</button><a href="produk.php" class="btn btn-secondary">Batal</a></div>
    </form>
</div></div></section>
<?php include "../includes/footer.php"; ?>

<?php
session_start();
require_once "../includes/auth.php";
$admin_layout = true; $page_title = 'Tambah Produk'; include "../includes/header.php";
$categories = ['Semen', 'Cat', 'Besi & Baja', 'Keramik', 'Perkakas', 'Pipa & Sanitasi', 'Kayu'];
?>
<section class="section"><div class="container"><div class="card">
    <?php include "../includes/flash.php"; ?>
    <span class="eyebrow">Create</span><h1 style="font-size:40px;">Tambah Produk</h1><p class="muted">Masukkan data produk baru ke katalog Toko Bangunan.</p>
    <form action="proses_produk.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="aksi" value="tambah">
        <div class="form-grid">
            <div class="field"><label>Nama Produk</label><input type="text" name="nama" maxlength="100" required placeholder="Contoh: Semen Premium 50kg"></div>
            <div class="field"><label>Kategori</label><select name="kategori" required><option value="">Pilih kategori</option><?php foreach($categories as $cat): ?><option value="<?= htmlspecialchars($cat); ?>"><?= htmlspecialchars($cat); ?></option><?php endforeach; ?></select></div>
            <div class="field full"><label>Deskripsi</label><textarea name="deskripsi" maxlength="500" required placeholder="Jelaskan fungsi atau spesifikasi singkat produk."></textarea></div>
            <div class="field"><label>Harga (Rp)</label><input type="number" name="harga" min="0" step="0.01" required placeholder="75000"></div>
            <div class="field"><label>Stok</label><input type="number" name="stok" min="0" required placeholder="20"></div>
            <div class="field full"><label>Gambar Produk</label><input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp"><div class="small muted">Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</div></div>
        </div>
        <div class="form-actions"><button type="submit" class="btn">Simpan Produk</button><a href="produk.php" class="btn btn-secondary">Kembali</a></div>
    </form>
</div></div></section>
<?php include "../includes/footer.php"; ?>

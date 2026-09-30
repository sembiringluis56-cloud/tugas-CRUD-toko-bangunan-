<?php
require_once "config/database.php";
require_once "config/store.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = mysqli_prepare($conn, "SELECT * FROM produk WHERE id = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$produk = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$produk) { http_response_code(404); die("Produk tidak ditemukan."); }
$page_title = $produk['nama'];
include "includes/header.php";
?>
<section class="section">
    <div class="container">
        <div class="detail-grid">
            <div class="card">
                <?php if ($produk['gambar']): ?><img src="uploads/produk/<?= htmlspecialchars($produk['gambar']); ?>" class="product-image detail" alt="<?= htmlspecialchars($produk['nama']); ?>"><?php endif; ?>
            </div>
            <div class="card">
                <span class="badge"><?= htmlspecialchars($produk['kategori']); ?></span>
                <h1 style="font-size:42px; margin-top:14px;"><?= htmlspecialchars($produk['nama']); ?></h1>
                <p class="muted"><?= nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
                <div class="price" style="font-size:30px; margin:22px 0 8px;">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></div>
                <p><strong>Stok tersedia:</strong> <?= (int)$produk['stok']; ?> unit</p>

                <?php if ((int)$produk['stok'] > 0): ?>
                <div class="order-box">
                    <div class="order-box-head">
                        <div>
                            <strong>Pesan lewat WhatsApp</strong>
                            <div class="small muted">Pesanan akan dikirim langsung ke <?= STORE_WHATSAPP_DISPLAY; ?></div>
                        </div>
                        <span class="wa-mini">WA</span>
                    </div>
                    <div class="order-grid">
                        <div>
                            <label for="jumlah">Jumlah</label>
                            <input id="jumlah" type="number" min="1" max="<?= (int)$produk['stok']; ?>" value="1">
                        </div>
                        <div>
                            <label for="nama_pelanggan">Nama</label>
                            <input id="nama_pelanggan" type="text" placeholder="Nama Anda">
                        </div>
                        <div class="order-full">
                            <label for="alamat_pelanggan">Alamat / keterangan</label>
                            <textarea id="alamat_pelanggan" rows="3" placeholder="Alamat pengiriman atau keterangan pesanan"></textarea>
                        </div>
                    </div>
                    <a id="order-wa" class="btn btn-whatsapp" target="_blank" rel="noopener" href="<?= htmlspecialchars(whatsapp_order_url($produk['nama'], 1)); ?>">
                        <span>☏</span> Pesan Sekarang via WhatsApp
                    </a>
                    <p class="small muted order-note">Setelah menekan tombol, WhatsApp akan terbuka dengan detail produk dan jumlah pesanan.</p>
                </div>
                <?php else: ?>
                    <div class="alert error">Produk sedang habis. Silakan hubungi kami melalui WhatsApp untuk informasi stok.</div>
                <?php endif; ?>

                <a href="produk.php" class="btn btn-secondary">← Kembali ke Katalog</a>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    const button = document.getElementById('order-wa');
    if (!button) return;

    const quantity = document.getElementById('jumlah');
    const name = document.getElementById('nama_pelanggan');
    const address = document.getElementById('alamat_pelanggan');
    const baseNumber = '<?= STORE_WHATSAPP; ?>';
    const productName = <?= json_encode($produk['nama'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    const maxStock = <?= (int)$produk['stok']; ?>;

    function updateWhatsAppLink() {
        let qty = parseInt(quantity.value, 10) || 1;
        qty = Math.max(1, Math.min(qty, maxStock));
        quantity.value = qty;

        const customerName = name.value.trim();
        const customerAddress = address.value.trim();
        let message = 'Halo Toko Bangunan, saya ingin membeli:\n\n';
        message += 'Produk: ' + productName + '\n';
        message += 'Jumlah: ' + qty + '\n';
        if (customerName) message += 'Nama: ' + customerName + '\n';
        if (customerAddress) message += 'Alamat / keterangan: ' + customerAddress + '\n';
        message += '\nMohon info ketersediaan, total harga, dan cara pembayarannya. Terima kasih.';
        button.href = 'https://wa.me/' + baseNumber + '?text=' + encodeURIComponent(message);
    }

    [quantity, name, address].forEach(function (el) {
        el.addEventListener('input', updateWhatsAppLink);
    });
    updateWhatsAppLink();
})();
</script>
<?php include "includes/footer.php"; ?>

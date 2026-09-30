<?php
if (!isset($page_title)) { $page_title = 'Toko Bangunan'; }
if (!isset($admin_layout)) { $admin_layout = false; }
require_once __DIR__ . "/../config/store.php";
$base_path = isset($admin_layout) && $admin_layout ? '../' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title); ?> | Toko Bangunan</title>
    <link rel="stylesheet" href="<?= $base_path; ?>assets/style.css">
</head>
<body>
<nav class="navbar">
    <div class="container nav-inner">
        <a class="brand" href="<?= $base_path; ?>index.php">
            <span class="brand-mark">TB</span>
            <span>Toko Bangunan</span>
        </a>
        <div class="nav-links">
            <a href="<?= $base_path; ?>index.php">Beranda</a>
            <a href="<?= $base_path; ?>produk.php">Produk</a>
            <a href="<?= $base_path; ?>tentang.php">Tentang Kami</a>
            <?php if ($admin_layout): ?>
                <a href="index.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $base_path; ?>auth/login.php">Admin</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<?php if (!$admin_layout): ?>
<a class="wa-float" href="https://wa.me/<?= STORE_WHATSAPP; ?>?text=<?= rawurlencode('Halo Toko Bangunan, saya ingin bertanya tentang produk.'); ?>" target="_blank" rel="noopener" aria-label="Chat WhatsApp Toko Bangunan">
    <span class="wa-icon">☏</span>
    <span>Chat WhatsApp</span>
</a>
<?php endif; ?>

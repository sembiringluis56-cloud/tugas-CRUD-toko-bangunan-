<?php
session_start();
if (isset($_SESSION['admin_id'])) { header('Location: ../admin/index.php'); exit; }
$page_title='Login Admin';
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Login Admin | Toko Bangunan</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="login-shell"><div class="card login-card">
    <a class="brand" href="../index.php"><span class="brand-mark">TB</span><span>Toko Bangunan</span></a>
    <h1 style="font-size:38px;margin-top:28px;">Login Admin</h1><p class="muted">Masuk untuk mengelola katalog produk Toko Bangunan.</p>
    <?php include "../includes/flash.php"; ?>
    <form action="proses_login.php" method="POST">
        <div class="field"><label>Username</label><input type="text" name="username" autocomplete="username" required></div>
        <div class="field"><label>Password</label><input type="password" name="password" autocomplete="current-password" required></div>
        <button type="submit" class="btn" style="width:100%;">Masuk ke Dashboard</button>
    </form>
    <p class="small" style="margin-top:20px;"><a href="../index.php">← Kembali ke website</a></p>
</div></div></body></html>

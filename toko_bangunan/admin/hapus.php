<?php
session_start();
require_once "../includes/auth.php";
require_once "../config/database.php";
$id = (int)($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, "SELECT gambar FROM produk WHERE id = ? LIMIT 1"); mysqli_stmt_bind_param($stmt,'i',$id); mysqli_stmt_execute($stmt); $data=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$data) { $_SESSION['error']='Produk tidak ditemukan.'; header('Location: produk.php'); exit; }
$stmt = mysqli_prepare($conn, "DELETE FROM produk WHERE id = ?"); mysqli_stmt_bind_param($stmt,'i',$id); $delete=mysqli_stmt_execute($stmt);
if ($delete) {
    if ($data['gambar'] && file_exists('../uploads/produk/'.$data['gambar'])) { @unlink('../uploads/produk/'.$data['gambar']); }
    $_SESSION['success']='Produk berhasil dihapus.';
} else { $_SESSION['error']='Produk gagal dihapus.'; }
header('Location: produk.php'); exit;

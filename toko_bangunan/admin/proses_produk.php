<?php
session_start();
require_once "../includes/auth.php";
require_once "../config/database.php";

$aksi = $_POST['aksi'] ?? '';
$allowed_categories = ['Semen','Cat','Besi & Baja','Keramik','Perkakas','Pipa & Sanitasi','Kayu'];
$upload_dir = '../uploads/produk/';

function validate_product($nama, $kategori, $deskripsi, $harga, $stok, $allowed_categories) {
    $errors = [];
    if (empty($nama)) $errors[] = 'Nama produk wajib diisi.';
    if (strlen($nama) > 100) $errors[] = 'Nama produk maksimal 100 karakter.';
    if (empty($kategori) || !in_array($kategori, $allowed_categories, true)) $errors[] = 'Kategori produk tidak valid.';
    if (empty($deskripsi)) $errors[] = 'Deskripsi wajib diisi.';
    if (strlen($deskripsi) > 500) $errors[] = 'Deskripsi maksimal 500 karakter.';
    if ($harga === '' || !is_numeric($harga) || (float)$harga < 0) $errors[] = 'Harga harus berupa angka yang valid.';
    if ($stok === '' || !is_numeric($stok) || (int)$stok < 0) $errors[] = 'Stok harus berupa angka yang valid.';
    return $errors;
}
function upload_image($field, $upload_dir, &$error) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) return null;
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) { $error='Upload gambar gagal.'; return false; }
    $file=$_FILES[$field]; $ext=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION)); $allowed=['jpg','jpeg','png','webp'];
    if (!in_array($ext,$allowed,true)) { $error='Format gambar tidak diperbolehkan.'; return false; }
    if ($file['size'] > 2*1024*1024) { $error='Ukuran gambar maksimal 2 MB.'; return false; }
    $new=uniqid('produk_',true).'.'.$ext;
    if (!move_uploaded_file($file['tmp_name'],$upload_dir.$new)) { $error='Gambar gagal disimpan.'; return false; }
    return $new;
}

if (!in_array($aksi,['tambah','edit'],true)) { $_SESSION['error']='Aksi tidak valid.'; header('Location: produk.php'); exit; }

$nama=trim($_POST['nama']??''); $kategori=trim($_POST['kategori']??''); $deskripsi=trim($_POST['deskripsi']??''); $harga=$_POST['harga']??''; $stok=$_POST['stok']??'';
$errors=validate_product($nama,$kategori,$deskripsi,$harga,$stok,$allowed_categories);
if ($errors) { $_SESSION['error']=implode(' ',$errors); header('Location: '.($aksi==='edit'?'edit.php?id='.(int)($_POST['id']??0):'tambah.php')); exit; }

$upload_error=''; $new_image=upload_image('gambar',$upload_dir,$upload_error);
if ($new_image===false) { $_SESSION['error']=$upload_error; header('Location: '.($aksi==='edit'?'edit.php?id='.(int)($_POST['id']??0):'tambah.php')); exit; }

if ($aksi==='tambah') {
    $stmt=mysqli_prepare($conn,"INSERT INTO produk (nama,kategori,deskripsi,harga,stok,gambar) VALUES (?,?,?,?,?,?)");
    $harga_num=(float)$harga; $stok_num=(int)$stok;
    mysqli_stmt_bind_param($stmt,'sssdis',$nama,$kategori,$deskripsi,$harga_num,$stok_num,$new_image);
    $ok=mysqli_stmt_execute($stmt);
    $_SESSION[$ok?'success':'error']=$ok?'Produk berhasil ditambahkan.':'Produk gagal ditambahkan.';
    header('Location: produk.php'); exit;
}

$id=(int)($_POST['id']??0);
$stmt=mysqli_prepare($conn,"SELECT gambar FROM produk WHERE id=? LIMIT 1"); mysqli_stmt_bind_param($stmt,'i',$id); mysqli_stmt_execute($stmt); $old=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$old) { if($new_image && file_exists($upload_dir.$new_image)) @unlink($upload_dir.$new_image); $_SESSION['error']='Produk tidak ditemukan.'; header('Location: produk.php'); exit; }
$image=$new_image ?: $old['gambar']; $harga_num=(float)$harga; $stok_num=(int)$stok;
$stmt=mysqli_prepare($conn,"UPDATE produk SET nama=?,kategori=?,deskripsi=?,harga=?,stok=?,gambar=? WHERE id=?"); mysqli_stmt_bind_param($stmt,'sssdisi',$nama,$kategori,$deskripsi,$harga_num,$stok_num,$image,$id); $ok=mysqli_stmt_execute($stmt);
if($ok && $new_image && $old['gambar'] && file_exists($upload_dir.$old['gambar'])) @unlink($upload_dir.$old['gambar']);
$_SESSION[$ok?'success':'error']=$ok?'Produk berhasil diperbarui.':'Produk gagal diperbarui.';
header('Location: produk.php'); exit;

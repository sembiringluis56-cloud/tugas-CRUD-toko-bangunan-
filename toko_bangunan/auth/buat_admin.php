<?php
require_once "../config/database.php";
$nama='Administrator'; $username='admin'; $password='admin123'; $password_hash=password_hash($password,PASSWORD_DEFAULT);
$stmt=mysqli_prepare($conn,"INSERT INTO admin (nama,username,password) VALUES (?,?,?)"); mysqli_stmt_bind_param($stmt,'sss',$nama,$username,$password_hash);
if(mysqli_stmt_execute($stmt)){ echo 'Admin berhasil dibuat. Username: admin | Password: admin123'; } else { echo 'Gagal membuat admin: '.htmlspecialchars(mysqli_error($conn)); }

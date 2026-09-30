<?php
session_start();
require_once "../config/database.php";
$username=trim($_POST['username']??''); $password=$_POST['password']??'';
if($username==='' || $password===''){ $_SESSION['error']='Username dan password wajib diisi.'; header('Location: login.php'); exit; }
$stmt=mysqli_prepare($conn,"SELECT id,nama,username,password FROM admin WHERE username=? LIMIT 1"); mysqli_stmt_bind_param($stmt,'s',$username); mysqli_stmt_execute($stmt); $admin=mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if($admin && password_verify($password,$admin['password'])){
    session_regenerate_id(true); $_SESSION['admin_id']=$admin['id']; $_SESSION['admin_nama']=$admin['nama']; $_SESSION['admin_username']=$admin['username']; header('Location: ../admin/index.php'); exit;
}
$_SESSION['error']='Username atau password salah.'; header('Location: login.php'); exit;

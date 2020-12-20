<?php

session_start();
require_once '../../config/config.php';
require_once '../../function/functions.php';

if (!isset($_SESSION['login'])) {
  
  // jika belum login sebagai admin
  header('Location: ../login.php?login_dulu');
  exit();
  
}

// tangkap id yang berada di url
$id = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_GET['id'])));

// perintah query
$query = "DELETE FROM tb_buku WHERE id = '$id'";

// menjalankan function hapus()
if (hapus($query) > 0) {
  
  // jika buku berhasil dihapus dari database
  set_flashdata('buku_berhasil', 'berhasil dihapus');
  
  header('Location: data_buku.php?berhasil');
  exit();
  
} else {
  
  // jika buku gagal dihapus dari database
  set_flashdata('buku_gagal', 'gagal dihapus');
  
  header('Location: data_buku.php?gagal');
  exit();
  
}
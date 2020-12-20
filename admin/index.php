<?php

session_start();
require_once '../config/config.php';
require_once '../function/functions.php';

if (!isset($_SESSION['login'])) {
  
  // jika belum login sebagai admin
  header('Location: login.php?login_dulu');
  exit();
  
}

$data['css'] = 'none.css';
$data['judul'] = 'Halaman Dashboard Admin';

view('../templates/header', $data);

?>

<div class="container mt-5 mb-3">
  <div class="row">
    <div class="col-md-6 m-auto">

      <!-- gambar -->
      <img src="<?= base_url('assets/images/backgrounds/dashboard.png'); ?>" alt="" class="img-fluid mb-5">

    </div>
    <div class="col-md-6 m-auto">

      <h4>Selamat Datang Di Dashboard Admin Aplikasi <strong class="text-primary">Buku Sederhana</strong></h4>
      <span class="text-black-50 d-block">silahkan kelola semua buku yang tersedia sesuai keinginan anda</span>
      <a href="<?= base_url('admin/buku/data_buku.php'); ?>" class="btn btn-primary text-light mt-3">
        <small class="fas fa-fw fa-book mr-1"></small>
        <small>Lihat Data Buku</small>
      </a>

    </div>
  </div>
</div>

<?php view('../templates/footer'); ?>
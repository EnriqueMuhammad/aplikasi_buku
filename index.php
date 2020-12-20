<?php

session_start();
require_once 'config/config.php';
require_once 'function/functions.php';

if (isset($_SESSION['login'])) {
  
  // jika sudah pernah login sebagai admin
  header('Location: admin/index.php?sudah_menjadi_admin');
  exit();
  
}

$data['css'] = 'none.css';
$data['title'] = 'Halaman Utama User';

view('templates/user_header', $data);

?>

<div class="container mt-3 mb-3">

  <div class="row">
    <div class="col-md-6">
      <!-- gambar -->
      <img src="<?= base_url('assets/images/backgrounds/book.png'); ?>" alt="" class="img-fluid mt-5 mb-5">
    </div>
    <div class="col-md-6 m-auto">
      <h3>Selamat Datang Di Aplikasi <strong class="text-primary">Buku Sederhana</strong></h3>
      <span class="text-blqck-50 d-block">dimana anda bisa melihat buku apa saja dan detail dari buku tersebut</span>
    </div>
  </div>

  <h5 class="text-center mt-5">Penjelasan</h5>

  <div class="row mt-5" id="d-mobile">
    <div class="col">
      <!-- card -->
      <div class="card shadow-sm rounded">
        <img src="<?= base_url('assets/images/backgrounds/reading.png'); ?>" class="card-img-top" alt="...">
        <div class="card-body">
          <span class="card-text d-block">berisikan kumpulan buku berkualitas bagus dan ditambah dengan detail buku yang jelas</span>
          <a href="<?= base_url('buku/buku.php'); ?>" class="btn btn-primary text-light mt-3">
            <small class="fas fa-fw fa-book mr-1"></small>
            <small>Lihat Kumpulan Buku</small>
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5" id="d-desk">
    <div class="col-md-6 m-auto">
      <h5 class="mb-5 d-block">berisikan kumpulan buku berkualitas bagus dan ditambah dengan detail buku yang jelas</h5>
      <a href="<?= base_url('buku/buku.php'); ?>" class="btn btn-primary text-light">
        <small class="fas fa-fw fa-book mr-1"></small>
        <small>Lihat Kumpulan Buku</small>
      </a>
    </div>
    <div class="col-md-6 m-auto">
      <!-- gambar -->
      <img src="<?= base_url('assets/images/backgrounds/reading.png'); ?>" alt="" class="img-fluid">
    </div>
  </div>

</div>

<?php view('templates/user_footer'); ?>
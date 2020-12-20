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

$data['css'] = 'none.css';
$data['judul'] = 'Halaman Detail Buku';
$data['buku'] = query("SELECT * FROM tb_buku WHERE id = '$id'")[0];

view('../../templates/header', $data);

?>

<div class="container mt-3 mb-3">
  <div class="row">
    <div class="col-md-6">

      <!-- gambar -->
      <div class="d-flex justify-content-center align-items-center flex-wrap flex-column">
        <img src="<?= base_url('assets/images/uploads/' . $data['buku']['gambar']); ?>" alt="" class="img-fluid shadow-sm mt-5 mb-3">
        <h4 class="text-black"><?= $data['buku']['judul']; ?></h4>
        <a href="ubah_buku.php?id=<?= $data['buku']['id']; ?>" class="btn btn-success text-light">
          <small class="fas fa-fw fa-edit mr-1"></small>
          <small>Ubah Buku</small>
        </a>
      </div>

    </div>
    <div class="col-md-6 mt-5">

      <h5 class="text-black">Pengarang :</h5>
      <span class="d-block mb-4"><?= $data['buku']['pengarang']; ?></span>

      <h5 class="text-black">Penerbit :</h5>
      <span class="d-block mb-4"><?= $data['buku']['penerbit']; ?></span>

      <h5 class="text-black">Tanggal Buku Terbit :</h5>
      <span class="d-block mb-4"><?= $data['buku']['tanggal_terbit']; ?></span>

      <h5 class="text-black">Genre :</h5>
      <span class="d-block mb-4"><?= $data['buku']['genre']; ?></span>

      <h5 class="text-black">Keterangan :</h5>
      <span class="d-block mb-3"><?= $data['buku']['keterangan']; ?></span>

      <a href="<?= base_url('admin/buku/data_buku.php'); ?>" class="btn btn-primary text-light">
        <small class="fas fa-fw fa-arrow-left mr-1"></small>
        <small>Kembali</small>
      </a>

    </div>
  </div>
</div>

<?php view('../../templates/footer'); ?>
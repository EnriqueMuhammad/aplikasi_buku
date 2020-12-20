<?php

session_start();
require_once '../config/config.php';
require_once '../function/functions.php';

if (isset($_SESSION['login'])) {
  
  // jika sudah pernah login sebagai admin
  header('Location: ../admin/index.php?sudah_menjadi_admin');
  exit();
  
}

// tangkap id yang berada di url
$id = trim(htmlspecialchars(mysqli_real_escape_string($conn, $_GET['id'])));

$data['css'] = 'none.css';
$data['judul'] = 'Halaman Detail Buku';
$data['buku'] = query("SELECT * FROM tb_buku WHERE id = '$id'")[0];

view('../templates/user_header', $data);

?>

<div class="container mt-3 mb-3">
  <div class="row">
    <div class="col-md-6">

      <!-- gambar -->
      <div class="d-flex justify-content-center align-items-center flex-wrap flex-column">
        <img src="<?= base_url('assets/images/uploads/' . $data['buku']['gambar']); ?>" alt="" class="img-fluid shadow-sm mt-5 mb-3">
        <h4 class="text-black"><?= $data['buku']['judul']; ?></h4>
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

      <a href="<?= base_url('buku/buku.php'); ?>" class="btn btn-primary text-light">
        <small class="fas fa-fw fa-arrow-left mr-1"></small>
        <small>Kembali</small>
      </a>

    </div>
  </div>
</div>

<?php view('../templates/user_footer'); ?>
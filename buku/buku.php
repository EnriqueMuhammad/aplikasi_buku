<?php

session_start();
require_once '../config/config.php';
require_once '../function/functions.php';

if (isset($_SESSION['login'])) {
  
  // jika sudah pernah login sebagai admin
  header('Location: ../admin/index.php?sudah_menjadi_admin');
  exit();
  
}

$data['css'] = 'none.css';
$data['judul'] = 'Halaman Kumpulan Buku';
$data['buku'] = query("SELECT * FROM tb_buku ORDER BY id DESC");

view('../templates/user_header', $data);

?>

<div class="container mt-3 mb-3">
  <div class="row mt-4 mb-4">
    <div class="col text-center">

      <h4>Halaman Kumpulan Buku</h4>
      <span class="text-black-50">berisi kumpulan berbagai macam buku berkualitas baik</span>

    </div>
  </div>
  <div class="row">
    <?php foreach ($data['buku'] as $buku) : ?>
    <?php $text = substr($buku['keterangan'], 0, 120); ?>
    <div class="col-md-6">
      
      <!-- card -->
      <div class="card shadow-sm rounded mb-3">
        <img class="card-img-top d-flex" src="<?= base_url('assets/images/uploads/' . $buku['gambar']); ?>" alt="Card image cap">
        <div class="card-body">
          <h5 class="card-title"><?= $buku['judul']; ?></h5>
          <span class="card-text d-block"><?= $text; ?> ...</span>
          <a href="detail_buku.php?id=<?= $buku['id']; ?>" class="btn btn-primary mt-3 mb-3 text-light">
            <small class="fas fa-fw fa-book mr-1"></small>
            <small>Detail Buku</small>
          </a>
          <span class="card-text d-block"><small class="text-muted">di posting pada tanggal <?= $buku['tanggal_post']; ?></small></span>
        </div>
      </div>

    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php view('../templates/user_footer'); ?>

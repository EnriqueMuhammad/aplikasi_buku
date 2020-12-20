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
$data['judul'] = 'Halaman Profile Admin';
$data['profile'] = query("SELECT * FROM tb_user WHERE id = '$id'")[0];

view('../../templates/header', $data);

?>

<div class="container mt-5 mb-3">
  <div class="row">
    <div class="col-md-6 m-auto">

      <div class="d-flex justify-content-center align-items-center flex-wrap flex-column">
        <img src="<?= base_url('assets/images/users/' . $data['profile']['gambar']); ?>" alt="" width="200" class="img-fluid mb-3">
        <h4 class="text-black mb-3"><?= $data['profile']['nama']; ?></h4>
        <a href="ubah_profile.php?id=<?= $data['profile']['id']; ?>" class="btn btn-success text-light mb-4">
          <small class="fas fa-fw fa-edit mr-1"></small>
          <small>Ubah Profile</small>
        </a>
      </div>

    </div>
    <div class="col-md-6 m-auto">
      
      <!-- flasher -->
      <?php if (flashdata('profile_berhasil')) : ?>
      <div class="flash-container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="d-block">Profile <strong><?= flashdata('profile_berhasil'); ?></strong></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php unset_flashdata('profile_berhasil'); ?>
      <?php endif; ?>
      
      <?php if (flashdata('profile_gagal')) : ?>
      <div class="flash-container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="d-block">Profile <strong><?= flashdata('profile_gagal'); ?></strong></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php unset_flashdata('profile_gagal'); ?>
      <?php endif; ?>

      <ul class="list-group shadow-sm">
        <li class="list-group-item bg-light">
          <i class="fas fa-fw fa-user mr-1"></i>
          <span>Profile Admin</span>
        </li>
        <li class="list-group-item"><strong>Nama : </strong><?= $data['profile']['nama']; ?></li>
        <li class="list-group-item"><strong>Usia : </strong><?= age($data['profile']['tahun_kelahiran'], date('Y')); ?> tahun</li>
        <li class="list-group-item"><strong>Email : </strong><?= $data['profile']['email']; ?></li>
        <li class="list-group-item"><strong>Password : </strong><?= $data['profile']['password']; ?></li>
      </ul>

    </div>
  </div>
</div>

<?php view('../../templates/footer'); ?>

<?php

session_start();
require_once '../config/config.php';
require_once '../function/functions.php';

if (isset($_SESSION['login'])) {
  
  // jika sudah pernah login sebagai admin
  header('Location: index.php?sudah_menjadi_admin');
  exit();
  
}

$data['css'] = 'none.css';
$data['judul'] = 'Halaman Login Admin';

view('../templates/user_header', $data);

// ketika tombol submit ditekan
if (isset($_POST['submit'])) {

  // jalankan function login()
  login($_POST);

}

?>

<div class="container mt-5 mb-3">
  <div class="row">
    <div class="col-md-6 m-auto" id="d-desk">

      <!-- gambar -->
      <div class="d-flex justify-content-center align-items-center flex-wrap flex-column">
        <img src="<?= base_url('assets/images/backgrounds/dashboard.png'); ?>" alt="" class="img-fluid">
      </div>

    </div>
    <div class="col-md-6 m-auto">

      <!-- flasher -->
      <?php if (flashdata('login_validation')) : ?>
      <div class="container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span><?= flashdata('login_validation'); ?></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php endif; ?>

      <div class="d-flex justify-content-center align-items-center flex-wrap flex-column">
        <h4 class="text-black mb-4">Form Login</h4>
      </div>

      <div class="container">
        <form action="" method="post">
          <div class="form-group">
            <input type="text" name="email" class="form-control p-4" id="email" placeholder="example@example.com" autocomplete="off" value="<?= $_SESSION['value']['email']; ?>">
          </div>
          <div class="form-group">
            <input type="password" name="password" class="form-control p-4" id="password" placeholder="password" autocomplete="off">
          </div>
          <button type="submit" name="submit" class="btn btn-primary text-light btn-block p-3">
            <i class="fas fa-fw fa-sign-in-alt mr-1"></i>
            <span>Login</span>
          </button>
        </form>
      </div>

    </div>
  </div>
</div>

<?php view('../templates/user_footer'); ?>
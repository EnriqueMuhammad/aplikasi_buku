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
$data['judul'] = 'Halaman Ubah Profile Admin';
$data['profile'] = query("SELECT * FROM tb_user WHERE id = '$id'")[0];

view('../../templates/header', $data);

// ketika tombol submit ditekan
if (isset($_POST['submit'])) {
  
  // maka jalankan function ubah_profile()
  if (ubah_profile($id, $_POST, $data['profile']['email'], $data['profile']['gambar']) > 0) {
    
    // jika profile berhasil diubah
    set_flashdata('profile_berhasil', 'berhasil diubah');
    
    header("Location: profile.php?id=$id");
    exit();
    
  } else {
    
    // jika profile gagal diubah
    set_flashdata('profile_gagal', 'gagal diubah');
    
    header("Location: profile.php?id=$id");
    exit();
    
  }
  
}

?>

<div class="container mt-3 mb-3">
  <div class="row">
    <div class="col-md-5">

      <div class="alert alert-primary" role="alert">
        <h4 class="alert-heading">Pemberitahuan</h4>
        <span class="d-block">isi semua field tersebut dengan benar dan jelas</span>
      </div>

      <img src="<?= base_url('assets/images/backgrounds/meet.png'); ?>" alt="" class="img-fluid mt-3" id="d-desk">

    </div>
    <div class="col-md-7">
      
      <?php if (flashdata('profile_validation')) : ?>
      <div class="flash-container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <h4 class="alert-heading">Peringatan</h4>
          <span class="d-block"><?= flashdata('profile_validation'); ?></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php unset_flashdata('profile_validation'); ?>
      <?php endif; ?>
      
      <?php if (flashdata('upload_error')) : ?>
      <div class="flash-container">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <h4 class="alert-heading">Peringatan</h4>
          <span class="d-block"><?= flashdata('upload_error'); ?></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php unset_flashdata('upload_error'); ?>
      <?php endif; ?>
      
      <!-- form -->
      <div class="card shadow-sm">
        <div class="card-header">
          <small class="fas fa-fw fa-book mr-1"></small>
          <small>Form Ubah Profile</small>
        </div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="nama"><small>Nama Lengkap</small></label>
              <input type="text" name="nama" class="form-control" id="nama" placeholder="nama lengkap" autocomplete="off" value="<?= $data['profile']['nama']; ?>">
            </div>
            <div class="form-group">
              <label for="tahun_kelahiran"><small>Tahun Kelahiran</small></label>
              <input type="text" name="tahun_kelahiran" class="form-control" id="tahun_kelahiran" placeholder="tahun kelahiran" autocomplete="off" value="<?= $data['profile']['tahun_kelahiran']; ?>">
            </div>
            <div class="form-group">
              <label for="email"><small>Email</small></label>
              <input type="text" name="email" class="form-control" id="email" placeholder="example@example.com" autocomplete="off" value="<?= $data['profile']['email']; ?>">
            </div>
            <div class="form-group">
              <label for="password"><small>Password</small></label>
              <input type="text" name="password" class="form-control" id="password" placeholder="password" autocomplete="off" value="<?= $data['profile']['password']; ?>">
            </div>
            <div class="form-group">
              <label for="gambar" class="d-block"><small>Gambar</small></label>
              <div class="d-flex jusfify-content-center align-items-center flex-wrap flex-column mt-3 mb-3">
                <img src="<?= base_url("assets/images/users/" . $data['profile']['gambar']); ?>" alt="" class="img-fluid">
              </div>
              <div class="custom-file">
                <input type="file" name="gambar" class="custom-file-input" id="gambar">
                <label class="custom-file-label" for="gambar">pilih file gambar</label>
              </div>
            </div>
            <button type="submit" name="submit" class="btn btn-success text-light">
              <small class="fas fa-fw fa-edit mr-1"></small>
              <small>Ubah Profile</small>
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<?php view('../../templates/footer'); ?>
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
$data['judul'] = 'Halaman Ubah Data Buku';
$data['genre'] = list_genre();
$data['buku'] = query("SELECT * FROM tb_buku WHERE id = '$id'")[0];

view('../../templates/header', $data);

// ketika tombol submit ditekan
if (isset($_POST['submit'])) {

  // menjalankan function ubah_buku()
  if (ubah_buku($_POST, $id, $data['buku']['gambar']) > 0) {

    // ketika data buku berhasil diubah dari database
    set_flashdata('buku_berhasil', 'berhasil diubah');

    header('Location: data_buku.php?berhasil');
    exit();

  } else {

    // ketika data buku gagal diubah dari database
    set_flashdata('buku_gagal', 'gagal diubah');

    header('Location: data_buku.php?gagal');
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

      <?php if (flashdata('buku_validation')) : ?>
      <div class="flash-container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <h4 class="alert-heading">Peringatan</h4>
          <span class="d-block"><?= flashdata('buku_validation'); ?></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php unset_flashdata('buku_validation'); ?>
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

      <!-- form box -->
      <div class="card rounded shadow-sm">
        <div class="card-header">
          <small class="fas fa-fw fa-book mr-1"></small>
          <small>Form Ubah Buku</small>
        </div>
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="judul"><small>Judul Buku</small></label>
              <input type="text" name="judul" class="form-control" id="judul" placeholder="judul buku" autocomplete="off" value="<?= $data['buku']['judul']; ?>">
            </div>
            <div class="form-group">
              <label for="pengarang"><small>Pengarang</small></label>
              <input type="text" name="pengarang" class="form-control" id="pengarang" placeholder="pengarang" autocomplete="off" value="<?= $data['buku']['pengarang']; ?>">
            </div>
            <div class="form-group">
              <label for="penerbit"><small>Penerbit</small></label>
              <input type="text" name="penerbit" class="form-control" id="penerbit" placeholder="penerbit" autocomplete="off" value="<?= $data['buku']['penerbit']; ?>">
            </div>
            <div class="form-group">
              <label for="keterangan"><small>Keterangan</small></label>
              <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control"><?= $data['buku']['keterangan']; ?></textarea>
            </div>
            <div class="form-group">
              <label for="genre"><small>Genre</small></label>
              <select name="genre" id="genre" class="form-control">
                <?php foreach ($data['genre'] as $genre) : ?>
                <?php if ($genre === $data['buku']['genre']) : ?>
                <option value="<?= $genre; ?>" selected><?= $genre; ?></option>
                <?php else : ?>
                <option value="<?= $genre; ?>"><?= $genre; ?></option>
                <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label for="tanggal_terbit"><small>Tanggal Terbit</small></label>
              <input type="date" name="tanggal_terbit" class="form-control" id="tanggal_terbit" value="<?= $data['buku']['tanggal_terbit']; ?>">
            </div>
            <div class="form-group">
              <label for="gambar" class="d-block"><small>Gambar</small></label>
              <div class="d-flex justify-content-center align-items-center flex-wrap flex-column mt-3 mb-3">
                <img src="<?= base_url('assets/images/uploads/' . $data['buku']['gambar']); ?>" alt="" class="img-fluid shadow-sm rounded">
              </div>
              <div class="custom-file">
                <input type="file" name="gambar" class="custom-file-input" id="gambar">
                <label class="custom-file-label" for="gambar">pilih file gambar</label>
              </div>
            </div>
            <button type="submit" name="submit" class="btn btn-primary text-light">
              <small class="fas fa-fw fa-edit mr-1"></small>
              <small>Ubah Buku</small>
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<?php view('../../templates/footer'); ?>
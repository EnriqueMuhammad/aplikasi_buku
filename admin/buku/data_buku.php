<?php

session_start();
require_once '../../config/config.php';
require_once '../../function/functions.php';

if (!isset($_SESSION['login'])) {
  
  // jika belum login sebagai admin
  header('Location: ../login.php?login_dulu');
  exit();
  
}

$data['css'] = 'none.css';
$data['judul'] = 'Halaman Kumpulan Data Buku';
$data['buku'] = query("SELECT * FROM tb_buku ORDER BY id DESC");

view('../../templates/header', $data);

?>

<div class="mt-3 mr-4 mb-3 ml-4">
  <div class="row">
    <div class="col-md-8">

      <?php if (flashdata('buku_berhasil')) : ?>
      <div class="flash-container">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <span class="d-block">Buku <strong><?= flashdata('buku_berhasil'); ?></strong></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php unset_flashdata('buku_berhasil'); ?>
      <?php endif; ?>
      
      <?php if (flashdata('buku_gagal')) : ?>
      <div class="flash-container">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <span class="d-block">Buku <strong><?= flashdata('buku_gagal'); ?></strong></span>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <?php unset_flashdata('buku_gagal'); ?>
      <?php endif; ?>

      <!-- tombol -->
      <a href="<?= base_url('admin/buku/tambah_buku.php'); ?>" class="btn btn-primary text-light mb-3 shadow-sm">
        <small class="fas fa-fw fa-plus mr-1"></small>
        <small>tambah buku</small>
      </a>

    </div>
  </div>
  <div class="row">
    <div class="col">

      <!-- table -->
      <div class="table-responsive">
        <table class="table table-striped shadow-sm" id="myTable">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Buku</th>
              <th>Pengarang</th>
              <th>Tanggal Terbit</th>
              <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data['buku'] as $buku) : ?>
            <tr>
              <td><small><?= $no++; ?></small></td>
              <td><small><?= strtolower($buku['judul']); ?></small></td>
              <td><small><?= strtolower($buku['pengarang']); ?></small></td>
              <td><small><?= strtolower($buku['tanggal_terbit']); ?></small></td>
              <td class="d-flex justify-content-center align-items-center">
                <a href="detail_buku.php?id=<?= $buku['id']; ?>" class="badge badge-primary p-2 text-light mr-1">
                  <small class="fas fa-fw fa-eye mr-1"></small>
                  <small>detail</small>
                </a>
                <a href="" class="badge badge-danger p-2 text-light badge-delete" data-target="hapus_buku.php?id=<?= $buku['id']; ?>">
                  <small class="fas fa-fw fa-trash-alt mr-1"></small>
                  <small>hapus</small>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<?php view('../../templates/footer'); ?>

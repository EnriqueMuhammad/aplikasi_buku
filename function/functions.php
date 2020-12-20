<?php

// koneksi
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// jika gagal terhubung ke database
if (!$conn) return mysqli_error();

function query($param) {

  if ($param) {

    global $conn;

    $query = mysqli_query($conn, $param);
    $rows = [];

    if (mysqli_num_rows($query) > 0) {

      while ($data = mysqli_fetch_assoc($query)) $rows[] = $data;

    }

    return $rows;

  }

}


function base_url($param = []) {
  
  /*
    ubah isi dari constanta BASE_URL terlebih dahulu
    sesuai url kalian masing masing dengan cara masuk ke folder config, lalu cari file config.php
  */
  
  if (filter_var(BASE_URL, FILTER_VALIDATE_URL)) {
    
    // jika isi dari constanta BASE_URL adalah berupa url yang valid
    $result = (!$param) ? BASE_URL : BASE_URL . $param;
    
    return $result;
    
  }
  
}


function view($param, $data = []) {
  
  if ($param) {
    
    // panggil file sesuai isi dari parameter variabel $param
    require_once $param . EXT[3];
    
  }
  
}


function set_flashdata($param1, $param2) {
  
  if ($param1 && $param2) {
    
    // keamanan
    $nama = trim(rtrim(stripslashes(htmlspecialchars($param1))));
    $pesan = trim(stripslashes(htmlspecialchars($param2)));
    
    return $_SESSION[$nama] = ['pesan' => $pesan];
    
  }
  
}


function flashdata($param) {
  
  if ($param) {
    
    // keamanan
    $nama = trim(rtrim(stripslashes(htmlspecialchars($param))));
    
    /*
      cek apakah ada nama session yang sama dengan isi dari parameter variabel $param
      jika ada, maka tampilkan pesan dari session tersebut
    */
    
    if (isset($_SESSION[$nama])) return $_SESSION[$nama]['pesan'];
    
  }
  
}


function unset_flashdata($param) {
  
  if ($param) {
    
    // keamanan
    $nama = trim(rtrim(stripslashes(htmlspecialchars($param))));
    
    /*
      cek apakah ada nama session yang sama dengan isi dari parameter variabel $param
      jika ada, maka hapus session tersebut
    */
    
    if (isset($_SESSION[$nama])) unset($_SESSION[$nama]);
    
  }
  
}


function list_genre() {
  
  /*
    jika ingin merubah isi dari constanta GENRE
    silahkan masuk ke folder config, lalu cari file bernama config.php
  */
  
  $list = GENRE;
  
  return $list;
  
}


function filtering_input($param) {
  
  if ($param) {
    
    /*
      keamanan untuk tiap tiap input
      supaya mengurangi resiko terkena peretasan
      oleh pihak yang tidak bertanggung jawab
    */
    
    return trim(stripslashes(htmlspecialchars($param)));
  
  }
  
}


function tambah_buku($data) {
  
  if ($data) {
    
    global $conn;
    
    // keamanan
    $judul = filtering_input($data['judul']);
    $pengarang = filtering_input($data['pengarang']);
    $penerbit = filtering_input($data['penerbit']);
    $keterangan = filtering_input($data['keterangan']);
    $genre = filtering_input($data['genre']);
    $tanggal_terbit = filtering_input($data['tanggal_terbit']);
    
    // catat tanggal, bulan dan tahun saat mempost data buku baru
    $tanggal_post = date('d M Y');
    
    // value dari setiap input
    $_SESSION['value'] = [
      'judul' => $judul,
      'pengarang' => $pengarang,
      'penerbit' => $penerbit,
      'keterangan' => $keterangan,
      'genre' => $genre,
      'tanggal_terbit' => $tanggal_terbit
    ];
    
    // lakukan uji validasi
    if (!buku_validation($judul, $pengarang, $penerbit, $keterangan, $genre, $tanggal_terbit)) {
      
      /*
        jika function buku_validation() mengembalikan boolean false
        tandanya ada kesalahan dalam uji validasi
        jika ada kesalahan, maka arahkan ke halaman tambah buku lagi
      */
      
      header('Location: ../buku/tambah_buku.php?form_validation');
      exit();
      
    } else {
      
      /*
        jika lolos uji validasi
        maka jalankan function upload gambar
      */
      
      $gambar = upload('uploads');
      
      if (!$gambar) {
        
        /*
          jika variabel $gambar menghasilkan boolean false
          tandanya ada kesalahan dalam mengupload file gambar
          jika ada kesalahan, maka arahkam ke halaman tambah buku lagi 
        */
        
        header('Location: ../buku/tambah_buku.php');
        exit();
        
      }
      
      // buat perintah query
      $query = "INSERT INTO tb_buku VALUES('', '$judul', '$pengarang', '$penerbit', '$keterangan', '$genre', '$tanggal_terbit', '$tanggal_post', '$gambar')";
      
      // jalankan perintah query
      mysqli_query($conn, $query);
      
      /*
        jika function di bawah jni menghasilkan angka yang lebih besar dari 0, maka data buku baru berhasil ditambahkan ke database
        namnun jika function di bawah ini menghasilkan angka 0, maka data buku baru gagal ditambahkan ke database
      */
      
      return mysqli_affected_rows($conn);
      
    }
    
  }
  
}


function empty_field($param1, $param2) {
  
  // keamanan
  $nama = filtering_input($param1);
  $field = filtering_input($param2);
  
  return set_flashdata($nama, "isi field $field terlebih dahulu dengan benar");
  
}


function too_short($param1, $param2) {
  
  // keamanan
  $nama = filtering_input($param1);
  $field = filtering_input($param2);
  
  return set_flashdata($nama, "$field terlalu pendek");
  
}


function too_long($param1, $param2) {
  
  // keamanan
  $nama = filtering_input($param1);
  $field = filtering_input($param2);
  
  return set_flashdata($nama, "$field terlalu panjang");
  
}


function buku_validation($judul, $pengarang, $penerbit, $keterangan, $genre, $ttl_terbit) {
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    /*
      jika request method yang dikirimkan adalah method POST
      maka lanjutkan untuk uji validasi
    */
    
    if (empty($judul)) {
      
      // jika field judul kosong
      empty_field('buku_validation', 'judul');
      
      return false;
      
    } else if (strlen($judul) <= 1) {
      
      // jika judul buku terlalu pendek
      too_short('buku_validation', 'judul buku');
      
      return false;
      
    }
    
    if (empty($pengarang)) {
      
      // jika field pengarang kosong
      empty_field('buku_validation', 'pengarang');
      
      return false;
      
    } else if (!preg_match("/^[a-zA-Z ]*$/", $pengarang)) {
      
      // jika field pengarang diisi selain huruf kecil dan besar
      set_flashdata('buku_validation', 'field pengarang hanya boleh diisi oleh huruf kecil dan besar saja');
      
      return false;
      
    } else if (strlen($pengarang) <= 2) {
      
      // jika nama pengarang terlaly pendek
      too_short('buku_validation', 'pengarang');
      
      return false;
      
    }
    
    if (empty($penerbit)) {
      
      // jika field penerbit kosong
      empty_field('buku_validation', 'penerbit');
      
      return false;
      
    } else if (!preg_match("/^[a-zA-Z0-9 ]*$/", $penerbit)) {
      
      // jika field penerbit diisi selain huruf kecil, besar dan angka
      set_flashdata('buku_validation', 'field pengarang hanya boleh diisi oleh huruf kecil, besar dan angka saja');
      
      return false;
      
    } else if (strlen($penerbit) <= 2) {
      
      // jika nama penerbit terlaly pendek
      too_short('buku_validation', 'penerbit');
      
      return false;
      
    }
    
    if (empty($keterangan)) {
      
      // jika field keterangan kosong
      empty_field('buku_validation', 'keterangan');
      
      return false;
      
    } else if (strlen($keterangan) <= 15) {
      
      // jika nama penerbit terlaly pendek
      too_short('buku_validation', 'keterangan');
      
      return false;
      
    }
    
    if (empty($genre)) {
      
      // jika field genre kosong
      empty_field('buku_validation', 'genre');
      
      return false;
      
    }
    
    if (empty($ttl_terbit)) {
      
      // jika field tanggal terbit kosong
      empty_field('buku_validation', 'tanggal terbit');
      
      return false;
      
    }
    
    // jika lolos validasi
    return true;
    
  }
  
}


function upload($param) {
  
  $nama_file = $_FILES['gambar']['name'];
  $ukuran_file = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmp_name = $_FILES['gambar']['tmp_name'];
  
  if ($error === 4) {
    
    // jika pengguna tidak mengupload file apapun
    set_flashdata('upload_error', 'harap upload gambar terlebih dahulu');
    
    return false;
  }
  
  // kumpulan ekstensi yang boleh untuk diupload, selain itu tidak boleh
  $ekstensi_gambar_valid = ['jpg', 'jpeg', 'png', 'gif'];
  
  /*
      | pecah isi dari variabel $nama_file menjadi array terlebih dahulu
      | jika di dalam variabel $nama_file ditemukan tanda . atau titik, maka pecah isi dari variabel $nama_file menjadi array
      | contoh : candra.jpg, maka akan dirubah seperti ini ['candra', 'jpg']
  */
  
  $ekstensi_gambar = explode('.', $nama_file);
  
  /*
      | strtolower berfungsi sebagai pengecil semua huruf, yanh tadinya seperti ini CANDRA.JPG, menjadi seperti imi candra.jpg
      | end berfungsi untuk mengambil index terakhir di sebuah array variabel $ekstensi_gambar
      | end digunakan untuk mengambil sebuah ekstensi file yang diupload oleh pengguna untuk dicek, apakah ekstensi nya berupa gambar atau tidak
      | contoh : candra.dwi.cahyo.jpg, maka akan di jadikan array terlebih dahulu seperti berikut ['candra', 'dwi', 'cahyo', 'jpg'], maka yang diambil oleh tag end adalah jpg
  */
  
  $ekstensi_gambar = strtolower(end($ekstensi_gambar));
  
  if (!in_array($ekstensi_gambar, $ekstensi_gambar_valid)) {
    
    // jika file yang diupload oleh pengguna bukanlah gambar
    set_flashdata('upload_error', 'yang anda upload bukanlah berupa file gambar');
    
    return false;
  }
  
  if ($ukuran_file > 5000000) {
    
    // jika file yang diupload oleh pengguna terlalu besar
    set_flashdata('upload_error', 'ukuran file gambar terlalu nesar');
    
    return false;
  }
  
  // generate ke nama baru
  $nama_file_baru = AUTHOR . uniqid();
  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_gambar;
  
  move_uploaded_file($tmp_name, "../../assets/images/$param/" . $nama_file_baru);
  
  return $nama_file_baru;
  
}


function hapus($param) {
  
  if ($param) {
    
    global $conn;
    
    // jalankan perintah query yang berada di dalam parameter variabel $param
    mysqli_query($conn, $param);
    
    /*
      jika function di bawah jni menghasilkan angka yang lebih besar dari 0, maka data buku baru berhasil dihapua dari database
      namnun jika function di bawah ini menghasilkan angka 0, maka data buku baru gagal dihapus dari database
    */
      
    return mysqli_affected_rows($conn);
    
  }
  
}


function ubah_buku($data, $id, $gambar_lama) {
  
  if ($data && $id && $gambar_lama) {
    
    global $conn;
    
    // keamanan
    $judul = filtering_input($data['judul']);
    $pengarang = filtering_input($data['pengarang']);
    $penerbit = filtering_input($data['penerbit']);
    $keterangan = filtering_input($data['keterangan']);
    $genre = filtering_input($data['genre']);
    $tanggal_terbit = filtering_input($data['tanggal_terbit']);
    
    // catat tanggal, bulan dan tahun saat mempost data buku baru
    $tanggal_post = date('d M Y');
    
    // lakukan uji validasi
    if (!buku_validation($judul, $pengarang, $penerbit, $keterangan, $genre, $tanggal_terbit)) {
      
      /*
        jika function buku_validation() mengembalikan boolean false
        tandanya ada kesalahan dalam uji validasi
        jika ada kesalahan, maka arahkan ke halaman ubah buku lagi
      */
      
      header("Location: ../buku/ubah_buku.php?id='$id'");
      exit();
      
    } else {
      
      // jika lolos uji validasi
      $result = ($_FILES['gambar']['error'] === 4) ? $gambar = $gambar_lama : $gambar = upload('uploads');
      
      if (!$gambar) {
        
        /*
          jika variabel $gambar menghasilkan boolean false
          tandanya ada kesalahan dalam mengupload file gambar
          jika ada kesalahan, maka arahkam ke halaman ubah buku lagi 
        */
        
        header("Location: ../buku/ubah_buku.php?id='$id'");
        exit();
        
      }
      
      // buat perintah query
      $query = "UPDATE tb_buku SET judul = '$judul', pengarang = '$pengarang', penerbit = '$penerbit', keterangan = '$keterangan', genre = '$genre', tanggal_terbit = '$tanggal_terbit', tanggal_post = '$tanggal_post', gambar = '$result' WHERE id = '$id'";
      
      // jalankan perintah query
      mysqli_query($conn, $query);
      
      /*
        jika function di bawah jni menghasilkan angka yang lebih besar dari 0, maka data buku baru berhasil diubah dari database
        namnun jika function di bawah ini menghasilkan angka 0, maka data buku baru gagal diubah dari database
      */
      
      return mysqli_affected_rows($conn);
      
    }
    
  }
  
}


function login($data) {
  
  if ($data) {
    
    global $conn;
    
    // keamanan
    $email = filtering_input($data['email']);
    $password = filtering_input($data['password']);
    
    // catat value dari input email
    $_SESSION['value'] = ['email' => $email];
    
    // lakukan validasi
    if (!login_validation($email, $password)) {
      
      /*
        jika function login validation menghasilkan boolean false
        maka tandanya ada kesalahan dalam uji validasi
        jika ada kesalahan, maka arahkan ke halaman login lagi
      */
      
      header('Location: ../admin/login.php?form_validation');
      exit();
      
    } else {
      
      // jika lolos dari validasi
      $result = query("SELECT * FROM tb_user WHERE email = '$email'")[0];
      
      if ($result) {
        
        /*
          jika email yang diinputkan sudah terdaftar sebagai admin
          maka lanjutkan pengecekan password
        */
        
        if ($password == $result['password']) {
          
          // sebagai penanda bahwa telah berhasil login sebagai admin
          $_SESSION['login'] = uniqid();
          
          $_SESSION['admin'] = [
            'id' => $result['id'],
            'nama' => $result['nama'],
            'tahun_kelahiran' => $result['tahun_kelahiran'],
            'email' => $result['email'],
            'password' => $result['password'],
            'gambar' => $result['gambar']
          ];
          
          // jika password benar
          header('Location: ../admin/index.php?login_sukses');
          exit();
          
        } else {
          
          // jika password salah
          set_flashdata('login_validation', 'password salah');
          
          header('Location: ../admin/login.php?password_salah');
          exit();
          
        }
        
      } else {
        
        // jika email atau password salah
        set_flashdata('login_validation', 'email atau password salah');
          
        header('Location: ../admin/login.php?kesalahan');
        exit();
        
      }
      
    }
    
  }
  
}


function login_validation($email, $password) {
  
  /*
    jjka request method yang dikirimkan dari form login adalah method post
    maka lanjutkan untuk melakukan validasi
  */
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($email)) {
      
      // jika field email kosong
      empty_field('login_validation', 'email');
      
      return false;
      
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      
      // jika email tidak valid
      set_flashdata('login_validation', 'bukan berupa format email yang valid');
      
      return false;
      
    }
    
    if (empty($password)) {
      
      // jika field password kosong
      empty_field('login_validation', 'password');
      
      return false;
      
    }
    
    // jika lolos validasi
    return true;
    
  }
  
}


function age($param1, $param2) {
  
  if ($param1 && $param2) {
    
    if (filter_var($param1, FILTER_VALIDATE_INT) && filter_var($param1, FILTER_VALIDATE_INT)) {
      
      return $param2 - $param1;
      
    }
    
  }
  
} 


function ubah_profile($id, $data, $email_lama, $gambar_lama) {
  
  global $conn;
  
  // keamanan
  $nama = filtering_input($data['nama']);
  $tahun = filtering_input($data['tahun_kelahiran']);
  $email = filtering_input($data['email']);
  $password = filtering_input($data['password']);
  
  // lakukan validasi
  if (!profile_validation($nama, $tahun, $email, $password)) {
    
   /*
      jika function profile validation menghasilkan boolean false
      maka tandanya ada kesalahan dalam uji validasi
      jika ada kesalahan, maka arahkan ke halaman ubah profile lagi
    */
      
    header("Location: ../profile/ubah_profile.php?id=$id");
    exit();
    
  } else {
    
    // jika lolos uji validasi
    
    if ($email !== $email_lama) {
      
      /*
        jika email yang ada di input tidak sama dengan email lama yang ada di database
        maka cek, apakah email tersebut sudah digunakan oleh admin lain atau tidak
      */
      
      set_flashdata('profile_validation', 'email tersebut sudah digunakan oleh admin lainnya');
      
      header("Location: ../profile/ubah_profile.php?id=$id");
      exit();
      
    }
    
    $result = ($_FILES['gambar']['error'] === 4) ? $gambar = $gambar_lama : $gambar = upload('users');
    
    if (!$result) {
      
      /*
        jika variabel $gambar menghasilkan boolean false
        tandanya ada kesalahan dalam mengupload file gambar
        jika ada kesalahan, maka arahkam ke halaman ubah profile lagi 
      */
      
      header("Location: ../profile/ubah_profile.php?id=$id");
      exit();
      
    }
    
    // buat perintah query
    $query = "UPDATE tb_user SET nama = '$nama', tahun_kelahiran = '$tahun', email = '$email', password = '$password', gambar = '$result' WHERE id = '$id'";
    
    // jalankan perintah query
    mysqli_query($conn, $query);
    
    /*
      jika function di bawah jni menghasilkan angka yang lebih besar dari 0, maka profile berhasil diubah dari database
      namnun jika function di bawah ini menghasilkan angka 0, maka profile gagal diubah dari database
    */
      
    return mysqli_affected_rows($conn);
    
  }
  
}


function profile_validation($nama, $tahun, $email, $password) {
  
  /*
    jjka request method yang dikirimkan dari form ubah profile adalah method post
    maka lanjutkan untuk melakukan validasi
  */
  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($nama)) {
      
      // jika field nama kosong
      empty_field('profile_validation', 'nama');
      
      return false;
      
    } else if (!preg_match("/^[a-zA-Z ]*$/", $nama)) {
      
      // jika field nama diisi selain huruf kecil dan besar
      set_flashdata('profile_validation', 'field nama hanya boleh diisi dengan huruf kecil dan besar saja');
      
      return false;
      
    } else if (strlen($nama) <= 2) {
      
      // jika nama terlalu pendek
      too_short('profile_validation', 'nama');
      
      return false;
      
    }
    
    if (empty($tahun)) {
      
      // jika fueld tahun kelahiran kosong
      empty_field('profile_validation', 'tahun kelahiran');
      
      return false;
      
    } else if (!preg_match("/^[0-9]*$/", $tahun)) {
      
      // jika field tahun kelahiran diisi selain angka
      set_flashdata('profile_validation', 'field tahun kelahiran hanya boleh diisi oleh angka saja dan tanpa spasi');
      
      return false;
      
    } else if (strlen($tahun) <= 3) {
      
      // jika tahun kelahiran terlalu pendek
      too_short('profile_validation', 'tahun kelahiran');
      
      return false;
      
    } else if (strlen($tahun) >= 5) {
      
      // jika tahun kelahiran terlalu panjang
      too_long('profile_validation', 'tahun kelahiran');
      
      return false;
      
    }
    
    if (empty($email)) {
      
      // jika field email kosong
      empty_field('profile_validation', 'email');
      
      return false;
      
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      
      // jika bukan berupa format email yang valid
      set_flashdata('profile_validation', 'bukan berupa format email yang valid');
      
      return false;
      
    }
    
    if (empty($password)) {
      
      // jika field password kosong
      empty_field('profile_validation', 'password');
      
      return false;
      
    } else if (strlen($password) <= 2) {
      
      // jika password terlalu pendek
      too_short('profile_validation', 'password');
      
      return false;
      
    }
    
    // jika lolos validasi
    return true;
    
  }
  
}

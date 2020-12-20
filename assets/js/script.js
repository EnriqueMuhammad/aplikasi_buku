/*
  nama : candra dwi cahyo
  umur : 16 tahun
  email : candradwicahyo18@gmail.com
*/

$(document).ready(function() {
  
  // plugin dataTables()
  $('#myTable').dataTable();
  
  // ketika tombol hapus ditekan
  $('.badge-delete').on('click', function(e) {
    
    // matikan fitur direct di attribute href nya
    e.preventDefault();
    
    // target utama
    const target = $(this).data('target');
    
    // plugin sweetalert 2
    swal.fire ({
      position: 'center',
      icon: 'warning',
      title: 'apakah sudah yakin',
      text: 'ingin menghapus data tersebut',
      showCancelButton: true,
      cancelButtonText: 'tidak',
      confirmButtonText: 'yakin'
    }).then(result => {
      
      // ketika tombol yakin ditekan
      if (result.value) document.location.href = target;
      
    });
    
  })
  
});

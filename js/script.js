$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $('.custom-file-label').html(fileName);
});

// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
});

$(document).ready(function() {
  $('.btn-alert').on('click', function(e){
    e.preventDefault();

    const href = $(this).attr('href');
    const nama  = $(this).data('nama');
    const status  = $(this).data('status');

    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: nama,
      icon: 'warning',
      showCancelButton: true,
      cancelButtonColor: '#3085d6',
      confirmButtonColor: '#d33',
      confirmButtonText: status,
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        document.location.href = href;
      }
    });
  });
});
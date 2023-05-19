$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $('.custom-file-label').html(fileName);
});

// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
});

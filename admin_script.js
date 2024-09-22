$(document).ready(function() {
  // Handle click for View Staff
  $('#view-staff-link').click(function(e) {
    e.preventDefault();
    $('#profile-section').load('view_staff.php');
  });

  // Handle click for Add Staff
  $('#add-staff-link').click(function(e) {
    e.preventDefault();
    $('#profile-section').load('add_staff.php');
  });

  // Handle click for Edit Staff
  $('#edit-staff-link').click(function(e) {
    e.preventDefault();
    $('#profile-section').load('edit_staff.php');
  });

  // Handle click for Delete Staff
  $('#delete-staff-link').click(function(e) {
    e.preventDefault();
    $('#profile-section').load('delete_staff.php');
  });
});

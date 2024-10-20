  // Handle click for View Patient
  $('#view-patient-link').click(function(e) {
    e.preventDefault();
    $('#profile-section').load('view_patient.php');
  });
  
   // Handle click for Edit Patient
  $('#edit-patient-link').click(function(e) {
    e.preventDefault();
    $('#profile-section').load('edit_patient.php');
  });
  
   // Handle click for Delete Patient
  $('#delete-patient-link').click(function(e) {
    e.preventDefault();
    $('#profile-section').load('delete_patient.php');
  });
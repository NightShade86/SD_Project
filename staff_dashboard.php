<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
      margin: 0;
      padding: 0;
    }

    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background-color: #343a40;
      padding-top: 60px;
      overflow-y: auto;
    }

    #sidebar .nav-item {
      border-bottom: 1px solid #495057;
    }

    #sidebar .nav-link {
      color: #ffffff;
      padding: 15px 20px;
      display: flex;
      align-items: center;
      font-size: 16px;
    }

    #sidebar .nav-link i {
      margin-right: 15px;
      font-size: 18px;
    }

    #sidebar .nav-link.active {
      background-color: #495057;
      color: #ffffff;
      font-weight: bold;
    }

    #sidebar .nav-link:hover {
      background-color: #495057;
      color: #ffffff;
    }

    .navbar-brand {
      font-weight: bold;
    }

    .col-md-10.offset-md-2 {
      padding-left: 20px;
    }

    main {
      padding: 20px;
    }

    .content {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 10px;
      border: 1px solid #ddd;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-2 p-0" id="sidebar">
        <nav class="nav flex-column">
          <!-- Patient Dropdown -->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white py-3" href="#" id="patientDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-procedures"></i> Manage Patients
            </a>
            <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="patientDropdown">
              <a class="dropdown-item" href="#view-patients">View Patients</a>
              <a class="dropdown-item" href="#add-patient">Add Patient</a>
              <a class="dropdown-item" href="#edit-patient">Edit Patient</a>
              <a class="dropdown-item" href="#delete-patient">Delete Patient</a>
            </div>
          </div>

          <!-- Appointment Dropdown -->
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white py-3" href="#" id="appointmentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-calendar-alt"></i> Manage Appointments
            </a>
            <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="appointmentDropdown">
              <a class="dropdown-item" href="#view-appointment">View Appointments</a>
              <a class="dropdown-item" href="#add-appointment">Add Appointment</a>
            </div>
          </div>

          <!-- Static Links -->
          <a class="nav-link text-white" href="#view-bills"><i class="fas fa-file-invoice-dollar"></i> View Bills</a>
          <a class="nav-link text-white" href="#view-transaction"><i class="fas fa-exchange-alt"></i> View Transactions</a>
          <a class="nav-link text-white" href="#generate-sales-report"><i class="fas fa-chart-line"></i> Generate Sales Report</a>
          <a class="nav-link text-white" href="#view-feedback"><i class="fas fa-comments"></i> View Feedback</a>
        </nav>
      </div>
      <div class="col-md-10 offset-md-2">
        <header>
          <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <a class="navbar-brand" href="#">Staff Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link" href="#view-profile"><i class="fas fa-user"></i> View Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#logout"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                </li>
              </ul>
            </div>
          </nav>
        </header>
        <main class="mt-4">
          <div class="content bg-white p-4 shadow-sm rounded" id="profile-section">
            <!-- Default content before loading profile -->
            <h3>Welcome to the Admin Dashboard</h3>
            <p>Use the sidebar to navigate through the different sections of the admin panel.</p>
          </div>
          <div class="content bg-white p-4 shadow-sm rounded" id="feedback-section" style="display: none;">
            <h3>Feedback</h3>
            <div id="feedback-content"></div>
          </div>
        </main>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="admin_script.js"></script>
</body>
</html>
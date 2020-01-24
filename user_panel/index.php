<?php
  session_start();
  if(isset($_SESSION['logged_on']))
  {
    $user_id = $_SESSION['logged_on'];
    require 'db_connect.php';
    $sql = "SELECT * FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $customer = $row['firstname'];
    $gender = $row['gender'];
  }
  else
  {
    echo '<script>alert("Login Required !");</script>';
    echo '<script>window.location = "/stocker/login.php";</script>';
  }
  require 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Stocker- Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->

  <!-- logo -->
  <link rel="icon" type = "image/png" href="/stocker/img/logo.png">
  <style media="screen">
    li[class = 'nav-item']:hover
    {
        background: rgba(255,255,255, 0.13);
    }
    a[class = 'canvasjs-chart-credit']
    {
      display:none;
    }
  </style>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="index.php">
          <img src="/stocker/img/logo1.PNG" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.php">
          <img src="images/logo-mini.svg" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
            <a href="#firstrow" class="nav-link">
              <i class="mdi mdi-chart-line"></i>Forecast Stock
              <!--<span class="badge badge-primary ml-1">New</span>-->
            </a>
          </li>
          <li class="nav-item">
            <a href="#secondrow" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Historic vs Predicted</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link hover">
              <i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Hello, <?= $customer ?> !</span>
              <?php
                if($gender=='Male')
                {
                  echo "<img class='img-xs rounded-circle' src='images/faces/male.png' alt='Profile image'>";
                }
                else
                {
                  echo "<img class='img-xs rounded-circle' src='images/faces/female.png' alt='Profile image'>";
                }
               ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">

              <a href = "readonly_profile.php" class="dropdown-item mt-2">
                Edit Profile
              </a>
              <a class="dropdown-item">
                Change Password
              </a>
              <a class="dropdown-item" href= "/stocker/user_panel/sign_out.php">
                Sign Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-profile active">
            <div class="nav-link">
              <div class="user-wrapper">
                <div class="profile-image">
                  <?php
                    if($gender=='Male')
                    {
                      echo "<img src='images/faces/male.png' alt='Profile image'>";
                    }
                    else
                    {
                      echo "<img src='images/faces/female.png' alt='Profile image'>";
                    }
                   ?>
                </div>
                <div class="text-wrapper">
                  <p class="profile-name active"><?= $customer ?></p>
                  <div>
                    <small class="designation text-muted">Manager</small>
                    <span class="status-indicator online"></span>
                  </div>
                </div>
              </div>
              <a style = 'text-decoration:none' href="stock.php"><button class="btn btn-success btn-block">New Stock
                <i class="mdi mdi-plus"></i>
              </button>
            </a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="stock.php">
              <i class="menu-icon mdi mdi-chart-line"></i>
              <span class="menu-title">Select Stock</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="readonly_profile.php">
              <i class="menu-icon mdi mdi-account-circle"></i>
              <span class="menu-title">Edit Profile</span>
            </a>
          </li>

        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-12 grid-margin">
              <div class="card" style = 'box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)'>
                <div class="card-body">
                  <h4 style = "font-size:22px" class="card-title">Your Recent History</h4>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <tbody>

                        <?php
                          require 'db_connect.php';
                          require 'displaystocktable.php';
                         ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

            <!--- ENF OF FIRST ROW ----------------------------->

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
              <a href="index.php" target="_blank">Stocker</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
              <i class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/chart.js"></script>
  <!-- End custom js for this page-->
</body>

</html>

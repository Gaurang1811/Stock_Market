<?php
  session_start();
  if(isset($_SESSION['logged_on']))
  {
    $user_id = $_SESSION['logged_on'];
    require 'db_connect.php';
    $sql = "SELECT firstname FROM user WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $customer = $row['firstname'];
    echo '<script>alert("Already Logged In!");</script>';
    echo '<script>window.location = "user_panel/stock.php";</script>';
  }
  else
  {
    require 'db_connect.php';

    if(isset($_POST['username']) && isset($_POST['password']))
    {
      $user = $_POST['username'];
      $password = $_POST['password'];
      $password = md5($password);
      $sql = "SELECT * from user WHERE username = '$user' AND password = '$password'";
      $result = mysqli_query($conn, $sql);
      $error = "Credentials do not match!";
      //print_r($result);

      if(mysqli_num_rows($result))
      {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['logged_on'] = $row['user_id'];
        header("Location: /stocker/user_panel/stock.php");
      }
      else
      {
        echo "<script>";
        echo "alert('Credentials Do Not Match')";
        echo "</script>";
      }
    }
  }

  ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Stocker | Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="user_panel/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="user_panel/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="user_panel/vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="user_panel/css/style.css">
  <!-- endinject -->
  <link rel="icon" type = "image/png" href="img/logo.png">
  <script>
    document.getElementById('error').style.display = "none";
  </script>
</head>

<body>

  <nav class="navbar navbar-light">
    <div class="container">
      <a class="navbar-brand" href="/stocker/"><img style = 'width:175px; height:55px' src="/stocker/img/logo1.PNG" alt=""></a>
      <a style = "float:right;text-transform: uppercase;" class="btn btn-link btn-fw" href="/stocker/aboutus/">About Us</a>
      <a style = "float:right;text-transform: uppercase;" class="btn btn-link btn-fw" href="/stocker/feedback/">Contact</a>
      <a style = "float:right;text-transform: uppercase;" class="btn btn-link btn-fw" href="#">Privacy Policy</a>
      <a style = "float:right;text-transform: uppercase;" class="btn btn-primary" href="/stocker/login.php">User Login</a>
      <a style = "float:right;text-transform: uppercase;" class="btn btn-success" href="/stocker/admin/">Admin Login</a>
    </div>
  </nav>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form action="#" method="POST">
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" name = 'username' class="form-control" placeholder="Username">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" name = 'password' class="form-control" placeholder="*********">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary submit-btn btn-block">Login</button>
                </div>
                <center><p class = 'text-danger' id = "error"></p></center>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked> Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="text-small forgot-password text-black">Forgot Password</a>
                </div>

                <div class="text-block text-center my-3">
                  <span class="text-small font-weight-semibold">Not a member ?</span>
                  <a href="register.php" class="text-black text-small">Create new account</a>
                </div>
              </form>
            </div>
            <ul class="auth-footer">
              <li>
                <a href="#">Conditions</a>
              </li>
              <li>
                <a href="#">Help</a>
              </li>
              <li>
                <a href="#">Terms</a>
              </li>
            </ul>
            <p class="footer-text text-center">Copyright © 2019
              <a href="/stocker/index.php" target = '_blank'>Stocker</a>. All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="user_panel/vendors/js/vendor.bundle.base.js"></script>
  <script src="user_panel/vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="user_panel/js/off-canvas.js"></script>
  <script src="user_panel/js/misc.js"></script>
  <!-- endinject -->
</body>

</html>

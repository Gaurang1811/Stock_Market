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
    echo '<script>alert("You Need To Log Out First !");</script>';
    echo '<script>window.location = "user_panel/stock.php";</script>';
  }

  require 'db_connect.php';


  if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']))
	{
		$user = $_POST['username'];
		$password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if($password == $confirm_password)
    {
      $password = md5($password);
      $sql = "SELECT * from user WHERE username = '$user'";
      $result = mysqli_query($conn, $sql);
      //print_r($result);

      if (mysqli_num_rows($result)==0)
      {
        $sql = "INSERT INTO user (username, password, firstname) VALUES ('$user', '$password', '$user')";
        mysqli_query($conn,$sql);
        $sql = "SELECT user_id FROM user WHERE username = '$user'";
        $result = mysqli_query($conn, $sql);
        $row = $result->fetch_assoc();
        $_SESSION['logged_on'] = $row['user_id'];
        header("Location: /stocker/user_panel/stock.php");

      }
      else
      {
        echo "<script>";
        echo "alert('User Already Exists!')";
        echo "</script>";
      }
    }
    else
    {
      echo "<script>";
      echo "alert('Passwords do not Match!')";
      echo "</script>";
    }
	}


 ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Stocker | Register</title>
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
  <link rel="icon" type = "image/png" href="/stocker/img/logo.png">
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
      <div class="content-wrapper d-flex align-items-center auth register-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <h2 class="text-center mb-4">Register</h2>
            <div class="auto-form-wrapper">
              <form action="#" method = "POST">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" name = 'username' class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="password" name = 'password' class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <input type="password" name = 'confirm_password' class="form-control" placeholder="Confirm Password" required>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group d-flex justify-content-center">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked> I agree to the terms
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <button class="btn btn-primary submit-btn btn-block">Register</button>
                </div>
                <div class="text-block text-center my-3">
                  <span class="text-small font-weight-semibold">Already have and account ?</span>
                  <a href="login.php" class="text-black text-small">Login</a>
                </div>
              </form>
            </div>
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

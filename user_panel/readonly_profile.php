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
  $firstname = '';
  $lastname = '';
  $gender = '';
  $dateofbirth = '';
  $address1 = '';
  $address2 = '';
  $state = '';
  $postcode = '';
  $city = '';
  $country = '';

  $sql = "SELECT * FROM user where firstname = '$customer'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) == 1)
  {
    $row = mysqli_fetch_assoc($result);
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $gender = $row['gender'];
    $dateofbirth = $row['dateofbirth'];
    $address1 = $row['address1'];
    $address2 = $row['address2'];
    $state = $row['state'];
    $postcode = $row['postcode'];
    $city = $row['city'];
    $country = $row['country'];
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Stocker- Your Profile</title>
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

              <a href = 'readonly_profile.php' class="dropdown-item mt-2">
                Edit Profile
              </a>
              <a class="dropdown-item">
                Change Password
              </a>
              <a class="dropdown-item" href= "/stocker/login.php">
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
                  <p class="profile-name"><?= $customer ?></p>
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
          <div class="row purchace-popup">

          </div>

          <div class="row">
          <!--  <div class="col-lg-7 grid-margin stretch-card">

          </div> -->

          </div>
          <div class="row">
            <div class="col-12 grid-margin">
              <div style = "box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)" class="card">
                <div class="card-body">
                  <h3 class="card-title">Update Your Profile</h3>
                  <hr>
                  <form class="form-sample" method = "POST" action = "edit_profile.php">
                    <p class="card-description">
                      Personal info
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">First Name</label>
                          <div class="col-sm-9">

                            <input name = 'firstname' type="text" class="form-control" value = '<?= $firstname ?>' readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Last Name</label>
                          <div class="col-sm-9">
                            <input name = 'lastname' type="text" class="form-control" value = '<?= $lastname ?>' readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Gender</label>
                          <div class="col-sm-9">
                            <select name = 'gender' class="form-control" disabled readonly>
                              <option value = '<?= $gender ?>' ><?= $gender ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date of Birth</label>
                          <div class="col-sm-9">
                            <input name = 'dateofbirth' type = 'text' value = '<?= $dateofbirth ?>' class="form-control" readonly />
                          </div>
                        </div>
                      </div>
                    </div>
                    <p class="card-description">
                      Address
                    </p>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address 1</label>
                          <div class="col-sm-9">
                            <input name = 'address1' value = '<?= $address1 ?>' type="text" class="form-control" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <input name = 'state' value = '<?= $state ?>' type="text" class="form-control" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address 2</label>
                          <div class="col-sm-9">
                            <input name = 'address2' value = '<?= $address2 ?>' type="text" class="form-control" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Postcode</label>
                          <div class="col-sm-9">
                            <input name = 'postcode' value = '<?= $postcode ?>' type="text" class="form-control" readonly/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">City</label>
                          <div class="col-sm-9">
                            <input name = 'city' value = '<?= $city ?>' type="text" class="form-control" readonly/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <select name = 'country' class="form-control" disabled readonly>
                              <option value = '<?= $country ?>'><?= $country ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Profile Picture</label>
                      <input type="file" name="img[]" class="file-upload-default" readonly>
                      <div class="input-group col-xs-12">
                        <input type="file" id = 'realinput' class="form-control file-upload-info" style = 'display:none' readonly>
                        <span class="form-control file-upload-info" id = 'file-info'>Upload an Image</span>
                        <span class="input-group-append">
                          <button id = 'uploadbutton' class="file-upload-browse btn btn-info" disabled type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    <div class = "row">

                        <button formmethod="POST" formaction = "edit_profile.php" class="btn btn-success mr-2">Edit Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
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
  <!-- End custom js for this page-->
  <script type="text/javascript">
    var uploadButton = document.getElementById("uploadbutton");
    const fileInfo = document.getElementById('file-info');
    const realInput = document.getElementById("realinput");
    uploadButton.addEventListener('click', (e) => {
      realInput.click();
    });
    realInput.addEventListener('change', () => {
      const name = realInput.value.split(/\\|\//).pop();
      const truncated = name.length > 20
      ? name.substr(name.length - 20)
      : name;
      fileInfo.innerHTML = truncated;
    });
  </script>
</body>

</html>

<?php
  require 'db_connect.php';
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

  if(isset($_POST['stock_name']))
  {
    $stock_name = $_POST['stock_name'];
    $security_code = '';
    $security_id = '';
    $sql = "SELECT * FROM stockname WHERE name = '$stock_name'";
    $result = mysqli_query($conn, $sql);

  	if(mysqli_num_rows($result) == 1)
  	{
    	$row = mysqli_fetch_assoc($result);
    	$security_id = $row['security_id'];
    	$security_code = $row['security_code'];
    }
    #---------------Entering User Choice In DB------------------------------


    $sql = "SELECT * FROM user_stock_history WHERE user_id = $user_id AND stock_id = $security_code";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0)
    {
      $row = mysqli_fetch_assoc($result);
      $hit = $row['hit'] + 1;
      $sql = "UPDATE user_stock_history SET hit = $hit WHERE user_id = $user_id AND stock_id = $security_code";
    }
    else
    {
      $sql = "INSERT INTO user_stock_history(user_id,stock_id,stock_name,hit) VALUES ($user_id, $security_code,'$stock_name', 1)";
    }
    $result = mysqli_query($conn, $sql);

    ini_set('max_execution_time', 10000);


  $output = shell_exec('C:\Users\Gaurang_PC\Anaconda3\envs\be\python python/forecast.py '.$security_code.' 2>&1');
  //print_r($output);

#---------------Historical vs Predicted data------------------------------
    $ann_url = 'python/json/ann_data.JSON';
    $ann_raw_data = file_get_contents($ann_url); // put the contents of the file into a variable
    $ann_data_set = json_decode($ann_raw_data);
    $ann_data = $ann_data_set->coordinates;

    for ($i=0; $i < count($ann_data); $i++)
    {
      $date_array[$i] = $ann_data[$i]->date;
      $y_test[$i] = $ann_data[$i]->y_test;
      $y_pred[$i] = $ann_data[$i]->y_pred;
    }

#------------------Importing Actual wap data-------------------------------
    $actual_wap_url = 'python/json/show_actual_wap_data.JSON';
    $actual_wap_raw_data = file_get_contents($actual_wap_url);
    $actual_wap_dataset = json_decode($actual_wap_raw_data);
    $actual_wap_data = $actual_wap_dataset->coordinates;

    for ($i=0; $i < count($actual_wap_data); $i++)
    {
      $actual_wap_date_array[$i] = $actual_wap_data[$i]->date;
      $actual_y_wap[$i] = $actual_wap_data[$i]->y_wap;
    }

#-----------------Importing Forecast Wap Data--------------------------------
    $forecast_wap_url = 'python/json/show_forecast_wap_data.JSON';
    $forecast_wap_raw_data = file_get_contents($forecast_wap_url);
    $forecast_wap_dataset = json_decode($forecast_wap_raw_data);
    $forecast_wap_data = $forecast_wap_dataset->coordinates;

    for ($i=0; $i < count($forecast_wap_data); $i++)
    {
        $forecast_wap_date_array[$i] = $forecast_wap_data[$i]->date;
        $forecast_y_wap[$i] = $forecast_wap_data[$i]->y_wap;
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Stocker- <?= $stock_name ?></title>
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
  <script>
window.onload = function ()
{

  function toggleDataSeries(e)
  {
    if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
      e.dataSeries.visible = false;
    } else {
      e.dataSeries.visible = true;
    }
    e.chart.render();
  }
//-----------------------------Forecast Graph Data-----------------------------


  var forecast_wap_date_array = <?php echo json_encode($forecast_wap_date_array); ?>;
  var forecast_y_wap = <?php echo json_encode($forecast_y_wap);  ?>;
  forecast_wap_date_array.reverse();
  forecast_y_wap.reverse();

  var actual_wap_date_array = <?php echo json_encode($actual_wap_date_array); ?>;
  var actual_y_wap = <?php echo json_encode($actual_y_wap);  ?>;
  actual_wap_date_array.reverse();
  actual_y_wap.reverse();

  var total_y_wap_limit = actual_y_wap.length + forecast_y_wap.length;

  var forecast_data = [];
  var date = '';
  var total_y_wap_dataSeries = { type: "line",connectNullData:true , lineThickness: 3};
  var total_y_wap_dataPoints = [];
  for (var k = 0,i = 0; i < total_y_wap_limit; i = i + 1)
  {
    if(i<actual_y_wap.length)
    {
      y = actual_y_wap[i];
      date = actual_wap_date_array[i];
      total_y_wap_dataPoints.push({
        x: i,
        y: y , label: date ,lineColor:"#ff0000", color: "#ff0000", name: "Actual WAP",showInLegend:true
      });
    }
    else
    {
      y = forecast_y_wap[k];
      date = forecast_wap_date_array[k];
      total_y_wap_dataPoints.push({
        x: i,
        y: y , label: date , color: "#1589FF", lineColor:"#1589FF", name: "Predicted WAP",showInLegend:true
      });
      k++;
    }


  }
  total_y_wap_dataSeries.dataPoints = total_y_wap_dataPoints;
  forecast_data.push(total_y_wap_dataSeries);



  var forecast_chart = new CanvasJS.Chart("forecast", {
    animationEnabled: true,
    animationDuration: 2000,
    zoomEnabled: true,
    theme: "light2",
    title:{
      text: 'WAP FORECAST- <?php echo $stock_name; ?>'
    },
    axisY :{
      title: "Stock Price in Rs.",
      interlacedColor: "#F0F8FF",
      tickColor: "azure",
      titleFontColor: "rgb(0,75,141)",
      gridColor: "rgba(105,105,105,.8)",
      labelFontSize: 20,
      titleFontSize: 25,
      includeZero:false
    },
    legend:{
      cursor: "pointer",
      fontSize: 23,
      itemclick: toggleDataSeries
    },
    toolTip: {
      shared: true,
      animationEnabled: true

    },
    axisX: {
      title: "Date",
      titleFontColor: "rgb(0,75,141)",
      labelFontSize: 15,
      titleFontSize: 25
    },
    data: forecast_data,

  });
  forecast_chart.render();




}
</script>
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
              <span class="profile-text">Hello, <?= $customer ?></span>
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
              <a class="dropdown-item" href= "sign_out.php">
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
          <div class="row purchace-popup">
          </div>

          <?php
            $latest_data_url = 'python/json/show_latest_data_record.JSON';
            $latest_data_raw_data = file_get_contents($latest_data_url);
            $latest_data_dataset = json_decode($latest_data_raw_data);
            $latest_data = $latest_data_dataset->coordinates;

            $latest_date = $latest_data[0]->date;
            $latest_open_price = $latest_data[0]->open_price;
            $latest_high_price = number_format((float)$latest_data[0]->high_price, 2, '.', '');
            $latest_low_price = number_format((float)$latest_data[0]->low_price, 2, '.', '');
            $latest_close_price = number_format((float)$latest_data[0]->close_price, 2, '.', '');
            $latest_wap = number_format((float)$latest_data[0]->y_wap, 2, '.', '');

           ?>
          <div id = "firstrow" class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-cube text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right"><h4>HIGH PRICE</h4></p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">&#8377;<?= $latest_high_price ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0">
                    <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i>Date: <?= $latest_date ?>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-receipt text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right"><h4>LOW PRICE</h4></p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">&#8377;<?= $latest_low_price ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0">
                    <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Date: <?= $latest_date ?>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-poll-box text-success icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right"><h4>CLOSE PRICE</h4></p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">&#8377;<?= $latest_close_price ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0">
                    <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i>Date: <?= $latest_date ?>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-account-location text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right"><h4 style = 'text-align:right'>WAP</h4></p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">&#8377;<?= $latest_wap ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0">
                    <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Date: <?= $latest_date ?>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div id="forecast" style="height: 365px; width: 100%">
                  </div>
              </div>
            </div>
          </div>
            <!--- ENF OF FIRST ROW ----------------------------->

        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
              <a href="/stocker/index.php" target="_blank">Stocker</a>. All rights reserved.</span>
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

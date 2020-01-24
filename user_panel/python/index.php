<?php

	$security_code = $_POST['security_code'];
	$security_id = '';
	$stock_name = '';
	$datapoints=[];
	$date_array=[];

	require 'db_connect.php';

	$sql = "SELECT * FROM stockname WHERE security_code = $security_code";
  	$result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result) == 1)
	{
    	$row = mysqli_fetch_assoc($result);
    	$security_id = $row['security_id'];
    	$stock_name = $row['name'];
    }

	$output = shell_exec('C:\Users\Admin\AppData\Local\Programs\Python\Python36-32\python random_forest_regression.py '.$security_code.' 2>&1');
	print_r($output);
	$datapoints=[];
	$date_array=[];
	$y_test=[];
	$y_pred=[];
	$url = 'ann_data.JSON';
	$raw_data = file_get_contents($url); // put the contents of the file into a variable
	$data_set = json_decode($raw_data);
	$data = $data_set->coordinates;

	for ($i=0; $i < count($data); $i++)
	{
	  $date_array[$i] = $data[$i]->date;
	  $y_test[$i] = $data[$i]->y_test;
	  $y_pred[$i] = $data[$i]->y_pred;
	}
?>

<!DOCTYPE HTML>
<html>
<head>

  <link rel = "icon" type = "image/png" href = "/stocker/img/logo.png">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Stocker</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.min.css" rel="stylesheet">
  <link href="css/custom.css" rel="stylesheet">

<script>
window.onload = function () {
var date_array = <?php echo json_encode($date_array);  ?>;
var y_test = <?php echo json_encode($y_test);  ?>;
var y_pred = <?php echo json_encode($y_pred);  ?>;

var limit = y_test.length+2;
var y = 0;
var data = [];
var y_test_dataSeries = { type: "line", color: "#1589FF", showInLegend:true,	name: "Test Data", axisYIndex: 1, connectNullData:true, };
var y_test_dataPoints = [];
for (var i = 0; i < limit; i = i + 1) {
	y = y_test[i];
	y_test_dataPoints.push({
		x: limit-i,
		y: y , label: date_array[i]
	});
}
y_test_dataSeries.dataPoints = y_test_dataPoints;
data.push(y_test_dataSeries);

var y_pred_dataSeries = {type: "line", color: "#FF0000", 	showInLegend:true, name: "Predicted Data", axisYIndex: 0, connectNullData:true}
var y_pred_dataPoints = [];
for (var i = 0; i < limit; i = i + 1)
{
  y = y_pred[i];
  y_pred_dataPoints.push({
    x: limit-i,
    y: y, label: date_array[i]
  });
}
y_pred_dataSeries.dataPoints = y_pred_dataPoints;
data.push(y_pred_dataSeries);

var counter=0;
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
  animationDuration: 2000,
	zoomEnabled: true,
  theme: "light2",
	title:{
		text: "Support Vector Machine Result for Ambuja BSE Stock"
	},
  axisY :{
		title: "Stock Price in Rs.",
		interlacedColor: "#F0F8FF",
		tickColor: "azure",
		titleFontColor: "rgb(0,75,141)",
		labelFontSize: 20,
		titleFontSize: 30,
		includeZero:true
  },
  axisX: {
		title: "Date",
		titleFontColor: "#1589FF",
		labelFontSize: 15,
		titleFontSize: 30,
	},
	data: data
});
chart.render();

}
</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script></head>
<body>

  <nav class="navbar navbar-light bg-light static-top">
    <div class="container">
      <a class="navbar-brand" href="/stocker/"><img style = 'width:60px;height:60px' src="/stocker/img/logo.png"></a>
      <a class="btn btn-primary" href="/stocker/admin/">Admin Login</a>
    </div>
  </nav>

 	<br>
    <div class="overlay text-center">
          <h1 class="mb-5">Welcome to Stocker!</h1>
    </div>

<div id="chartContainer" style="height: 430px; width: 100%;">
</div>
</body>
</html>

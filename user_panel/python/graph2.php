<?php

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
  <style media="screen">
  a[class = 'canvasjs-chart-credit']
  {
  	display:none;
  }
  </style>
<script>
window.onload = function () {
var date_array = <?php echo json_encode($date_array);  ?>;
var y_test = <?php echo json_encode($y_test);  ?>;
var y_pred = <?php echo json_encode($y_pred);  ?>;

var limit = y_test.length+2;
var y = 0;
var data = [];
var y_test_dataSeries = { type: "line", color: "#1589FF", showInLegend:true,	name: "Test Data", axisYIndex: 1, connectNullData:true };
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
  legend:{
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	toolTip: {
		shared: true
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

function toggleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();

}
}

</script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script></head>
<body>
<div id="chartContainer" style="height: 500px; width: 100%;">
</div>
</body>
</html>

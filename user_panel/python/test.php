<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
	var chart = new CanvasJS.Chart("chartContainer", {
	title:{
		text: "Weekly Revenue Analysis for First Quarter"
	},
	axisY:[{
		title: "Order",
		lineColor: "#C24642",
		tickColor: "#C24642",
		labelFontColor: "#C24642",
		titleFontColor: "#C24642",
		suffix: "k"
	},
	{
		title: "Footfall",
		lineColor: "#369EAD",
		tickColor: "#369EAD",
		labelFontColor: "#369EAD",
		titleFontColor: "#369EAD",
		suffix: "k"
	}],
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "line",
		name: "Footfall",
		color: "#369EAD",
		showInLegend: true,
		axisYIndex: 1,
		dataPoints: [
			{ x: new Date(2017, 00, 7), y: 85.4 }, 
			{ x: new Date(2017, 00, 14), y: 92.7 },
			{ x: new Date(2017, 00, 21), y: 64.9 },
			{ x: new Date(2017, 00, 28), y: 58.0 },
			{ x: new Date(2017, 01, 4), y: 63.4 },
			{ x: new Date(2017, 01, 11), y: 69.9 },
			{ x: new Date(2017, 01, 18), y: 88.9 },
			{ x: new Date(2017, 01, 25), y: 66.3 },
			{ x: new Date(2017, 02, 4), y: 82.7 },
			{ x: new Date(2017, 02, 11), y: 60.2 },
			{ x: new Date(2017, 02, 18), y: 87.3 },
			{ x: new Date(2017, 02, 25), y: 98.5 }
		]
	},
	{
		type: "line",
		name: "Order",
		color: "#C24642",
		axisYIndex: 0,
		showInLegend: true,
		dataPoints: [
			{ x: new Date(2017, 00, 7), y: 32.3 }, 
			{ x: new Date(2017, 00, 14), y: 33.9 },
			{ x: new Date(2017, 00, 21), y: 26.0 },
			{ x: new Date(2017, 00, 28), y: 15.8 },
			{ x: new Date(2017, 01, 4), y: 18.6 },
			{ x: new Date(2017, 01, 11), y: 34.6 },
			{ x: new Date(2017, 01, 18), y: 37.7 },
			{ x: new Date(2017, 01, 25), y: 24.7 },
			{ x: new Date(2017, 02, 4), y: 35.9 },
			{ x: new Date(2017, 02, 11), y: 12.8 },
			{ x: new Date(2017, 02, 18), y: 38.1 },
			{ x: new Date(2017, 02, 25), y: 42.4 }
		]
	}]
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
</head>
<body>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>
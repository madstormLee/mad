google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);

function drawChart() {
	var contents = jQuery.parseJSON( $('#chart').html() );
	var data = google.visualization.arrayToDataTable( contents );

	var options = {
		title: $('#main>h2').html(),
		hAxis: {title: 'Day', titleTextStyle: {color: '#000'}}
	};

	var chart = new google.visualization.ColumnChart(document.getElementById('chart'));
	chart.draw(data, options);
}

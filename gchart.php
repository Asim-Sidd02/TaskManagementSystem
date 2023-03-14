<?php
// Connect to the database
 

// Create an array to store the chart data
$chart_data = array();

// Loop through the data and add it to the chart data array
foreach ($data as $row) {
    $chart_data[] = array(
        'label' => $row['name'],
        'start' => $row['start_date'],
        'end' => $row['end_date']
    );
}

// Encode the data as JSON
$chart_data = json_encode($chart_data);
?>

<html>
<head>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'name');
      data.addColumn('string', 'description');
   
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'manager_id');
      data.addColumn('number', 'manager_id');
      data.addColumn('string', 'user_ids');

      data.addRows([
        <?php
        $query = $db->prepare("SELECT * FROM project_list");
$query->execute();
$data = $query->fetchAll();

// Create an array to store the chart data
$chart_data = array();

// Loop through the data and add it to the chart data array
foreach ($data as $row) {
    $chart_data[] = array(
        'label' => $row['name'],
        'start' => $row['start_date'],
        'end' => $row['end_date']
    );
}

// Encode the data as JSON
$chart_data = json_encode($chart_data);
?>
      ]);

      var options = {
        height: 400,
        gantt: {
          trackHeight: 30
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="chart_div"></div>
</body>
</html>






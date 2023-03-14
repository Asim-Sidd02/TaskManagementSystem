<?php
// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=tms_db', 'root', '');

// Fetch the data from the database
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

<!-- Create a container for the Gantt chart -->
<div id="chart"></div>

<!-- Use JavaScript to create the Gantt chart and insert the data -->
<script>
    // Function to create the Gantt chart
    function createGanttChart(data, target) {
        // Initialize a new Gantt chart
        var gantt = new GanttChart(target);

        // Add data to the chart
        for (var i = 0; i < data.length; i++) {
            gantt.addTask(data[i].label, data[i].start, data[i].end);
        }

        // Render the chart
        gantt.render();
    }

    // Get the chart data from PHP
    var chart_data = <?php echo $chart_data; ?>;

    // Create the chart and insert it into the "chart" element
    createGanttChart(chart_data, "chart");
</script>
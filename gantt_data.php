<?php
// Connect to the database
$cnx = new mysqli("localhost", "root", "", "tms_db");

// Execute a query to retrieve the data
$query = 'SELECT name, start_date, end_date FROM project_list';
$result = $cnx->query($query);

// Fetch the data
$data = $result->fetch_all(MYSQLI_ASSOC);

// Close the connection
$cnx->close();

?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <style>
        /* CSS styling for the chart */
        .chart {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12px;
            width: 100%;
            height: 500px;
            margin: 0;
        }

        .chart rect {
            fill: steelblue;
        }

        .chart text {
            font-color: black;
            fill: white;
            font-weight: bold;
            text-anchor: middle;
        }

    </style>
</head>
<body>

<div class="chart"></div>

<script>
    // Create a new Gantt chart
    var chart = d3.select(".chart")
        .append("svg")
        .attr("width", "100%")
        .attr("height", "500px");

    // Get the data from PHP
    var data = <?php echo json_encode($data); ?>;

    // Set the scales for the chart
    var x = d3.scaleTime()
        .domain([new Date(data[0].start_date), new Date(data[data.length-1].end_date)])
        .range([50,950]);

    var y = d3.scaleBand()
        .domain(data.map(function(d) { return d.name; }))
        .range([50,450])
        .padding(0.1);

    // Add the bars for each task
    chart.selectAll("rect")
        .data(data)
        .enter()
        .append("rect")
        .attr("x", function(d) { return x(new Date(d.start_date)); })
        .attr("y", function(d) { return y(d.name); })
        .attr("width", function(d) { return x(new Date(d.end_date)) - x(new Date(d.start_date)); })
        .attr("height", y.bandwidth());


        chart.selectAll("text")
        .data(data)
        .enter()
        .append("text")
        .text(function(d) { return d.name; })
        .attr("x", function(d) { return x(new Date(d.start_date)) + (x(new Date(d.end_date)) - x(new Date(d.start_date)))/2; })
        .attr("y", function(d) { return y(d.name) + y.bandwidth()/2; })
        .attr("dy", "0.35em")
        .attr("text-anchor", "middle");



           // Add the date time line
    var timeScale = d3.scaleTime()
        .domain([new Date(data[0].start_date), new Date(data[data.length-1].end_date)])
        .range([50,950]);

    var timeAxis = d3.axisBottom(timeScale)
        .ticks(d3.timeMonth.every(1))
        .tickFormat(d3.timeFormat("%b %Y"));

    chart.append("g")
        .attr("transform", "translate(450,0)")
        .call(timeAxis)
        .selectAll("text")
        .style("fill", "blue"); // change text color to red

    // Add the date time line for days
    var dayScale = d3.scaleTime()
        .domain([new Date(data[0].start_date), new Date(data[data.length-1].end_date)])
        .range([50,950]);

    var dayAxis = d3.axisBottom(dayScale)
        .ticks(d3.timeDay.every(1))
        .tickFormat(d3.timeFormat("%d"));

    chart.append("g")
        .attr("transform", "translate(0,470)")
        .call(dayAxis)
        .selectAll("text")
        .style("fill", "blue"); 


        chart.selectAll("text.label")
        .data(data)
        .enter()
        .append("text")
        .attr("class", "label")
        .attr("x", function(d) { return x(new Date(d.start_date)) - 10; })
        .attr("y", function(d, i) { return y(d.name) + y.bandwidth()/2 + 4; })
        .text(function(d, i) { return i + 1; })
        .style("fill", "red"); // change text color to red






    </script>
    </body>
    </html>

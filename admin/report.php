<?php include "./snippets/base.php" ?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "./snippets/layout/head.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Pie Chart Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .chart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin: 20px 10px;
        }

        canvas {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            height: auto;
        }

        .print-btn {
            color: white;
            width: 20%;
            padding: 10px;
            background-color: #364F6B;
            border: none;
            cursor: pointer;
            justify-content: center;
            margin-left: 550px;
        }

        @media screen and (min-width: 600px) {
            /* Apply styles for tablets */
            .chart-container {
                margin: 20px;
            }

        }

        @media screen and (min-width: 768px) {
            /* Apply styles for small desktops and tablets */
            .chart-container {
                margin: 20px 50px;
            }

        }

        @media screen and (min-width: 1024px) {
            /* Apply styles for larger screens, e.g., desktops */
            .chart-container {
                margin: 20px 100px;
            }

        }
    </style>
</head>
<body>
<?php include "./snippets/layout/header.php" ?>
<br>
<div class="chart-container">
    <canvas id="myPieChart" width="400" height="400"></canvas>
    <canvas id="myBarChart" width="400" height="400"></canvas>
</div>
<button class="print-btn" onclick="printCharts()">Download Charts as PDF</button>
<br><br><br>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sample data for the pie chart
        var pieData = {
            labels: ['Label 1', 'Label 2', 'Label 3'],
            datasets: [{
                data: [30, 40, 30],
                backgroundColor: ['#364F6B', '#3FC1C9', '#FC5185']
            }]
        };

        // Get the context of the first canvas element
        var pieCtx = document.getElementById('myPieChart').getContext('2d');

        // Create the pie chart
        var myPieChart = new Chart(pieCtx, {
            type: 'pie',
            data: pieData,
            options: {
                responsive: false,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            font: {
                                size: 20 // Adjust the font size of the labels
                            }
                        }
                    }
                }
            }
        });

        // Sample data for the bar chart
        var barData = {
            labels: ['Label 1', 'Label 2', 'Label 3'],
            datasets: [{
                label: 'Sample Data 1',
                data: [30, 40, 30],
                backgroundColor: '#3FC1C9'
            }, {
                label: 'Sample Data 2',
                data: [20, 50, 30],
                backgroundColor: '#364F6B'
            }, {
                label: 'Sample Data 3',
                data: [10, 30, 20],
                backgroundColor: '#FC5185'
            }]
        };

        // Get the context of the second canvas element
        var barCtx = document.getElementById('myBarChart').getContext('2d');

        // Create the bar chart
        var myBarChart = new Chart(barCtx, {
            type: 'bar',
            data: barData,
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            font: {
                                size: 13 // Adjust the font size of the labels
                            }
                        }
                    }
                }
            }
        });
    });

    function printCharts() {
        window.print();
    }
</script>
<?php include "./snippets/layout/footer.php" ?>
<!-- Javascripts -->
<?php include "./snippets/layout/scripts.php" ?>
<script src="./assets/js/header.js"></script>

</body>

</html>
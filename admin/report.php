<?php include "../snippets/base.php" ?>
<?php
require("../snippets/force_loggin.php");
if ($user["user_type_id"] != "3" && $user["user_type_id"] != "4") {
    die("Access Denied");
}
// Set the desired user_type_ids
$MemberUserTypeId = 1;
$VisitorUserTypeId = 2;
$violationTypeIds = [2, 1, 3];
// Get the current month and year
$currentMonth = date('m');
$currentYear = date('Y');


// Get reservation count
$MemberReservationCount = getReservationCount($MemberUserTypeId, $connection, $currentMonth, $currentYear);
$VisitorReservationCount = getReservationCount($VisitorUserTypeId, $connection, $currentMonth, $currentYear);

// Store results for Member and Visitor in arrays
$MemberViolationResults = [];
$VisitorViolationResults = [];

foreach ($violationTypeIds as $violationTypeId) {
    $MemberViolationCount = getViolationCount($MemberUserTypeId, $violationTypeId, $connection, $currentMonth, $currentYear);
    $MemberViolationResults[] = $MemberViolationCount;

    $VisitorViolationCount = getViolationCount($VisitorUserTypeId, $violationTypeId, $connection, $currentMonth, $currentYear);
    $VisitorViolationResults[] = $VisitorViolationCount;
}

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../snippets/layout/head.php" ?>
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
<?php include "../snippets/layout/header.php" ?>
<br>
<h3 style="text-align: center"><?= date('F-Y') ?> Report</h3>
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
            labels: ['Visitor', 'Member'],
            datasets: [{
                data: [<?= $VisitorReservationCount?>, <?= $MemberReservationCount?>],
                backgroundColor: ['#364F6B', '#FC5185']
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
            labels: ['Parked on a wrong parking', 'Exceeding the time allowed for parking', 'Extended reservation 3 times'],
            datasets: [{
                label: 'Visitor',
                data: <?= json_encode($VisitorViolationResults); ?>,
                backgroundColor: '#364F6B'
            }, {
                label: 'Member',
                data: <?= json_encode($MemberViolationResults); ?>,
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
                                size: 12 // Adjust the font size of the labels
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
<?php include "../snippets/layout/footer.php" ?>
<!-- Javascripts -->
<?php include "../snippets/layout/scripts.php" ?>
<script src="/assets/js/header.js"></script>

</body>

</html>
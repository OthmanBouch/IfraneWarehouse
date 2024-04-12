<?php
@include 'config.php';

session_start();

if (!isset($_SESSION['admin_name'])) {
    header('location:login.php');
    exit(); // Add exit after redirecting to prevent further execution
}

// hna ghanakhdo ch7al dyal items li pending o ch7al li arrived
$query = "SELECT Status, COUNT(*) AS count FROM product_supplier GROUP BY Status";
$result = mysqli_query($conn, $query);

$arrivedCount = 0;
$pendingCount = 0;

// o hna ghadi nsetiw ghir status as a hover m3a numbers of items 
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Status'] === 'Arrived') {
        $arrivedCount = $row['count'];
    } elseif ($row['Status'] === 'Pending') {
        $pendingCount = $row['count'];
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>User Page</title>
    <link rel="stylesheet" href="css/style3.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" type="x-icon" href="AppFavicon.png">
    <link rel="stylesheet" href="css/font-awesome-4.7.0/">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    /* Define flex container */
    .container {
        display: flex;
        justify-content: center; /* Center items horizontally */
        align-items: center;
        height: 100vh; /* Full height of viewport */
    }

    /* Style for the chart container */
    #pieChartContainer {
        padding: 20px; /* Adjust padding as needed */
        background-color: #f2f2f2; /* Grey background color */
        border-radius: 10px; /* Rounded corners */
        text-align: center;
    }
</style>

</head>
<body style="background: url(LogInImage.jpg);background-repeat: no-repeat;background-size: 100%;">

<br>
<H3 style="text-align: center; margin: 0; color: brown; font-family: 'Helvetica', sans-serif; font-size: 24px; font-weight: bold; text-transform: uppercase; text-shadow: 2px 2px 4px rgba(165, 42, 42, 0.5);">Dashboard</H3>

<div class="container">
        <div id="pieChartContainer">
            <h6>Pending Orders VS Arrived Orders</h6>
            <!-- Add a canvas element for the pie chart -->
            <canvas id="pieChart" width="400" height="400"></canvas>
        </div>
    </div>
<script>
    // Get the canvas element
    var ctx = document.getElementById('pieChart').getContext('2d');

    // Create the pie chart
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Arrived', 'Pending'],
            datasets: [{
                label: 'Status',
                data: [<?php echo $arrivedCount; ?>, <?php echo $pendingCount; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            // Add any options you want here
        }
    });
</script>
<?php include 'navbaradmin.php'; ?>
</body>
</html>




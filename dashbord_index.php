<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="dashbord.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <header class="text-center mb-4">
            <h1>POS Dashboard</h1>
        </header>

        <!-- Sales by Counter Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Sales by Counter</h2>
                    </div>
                    <div class="card-body" id="countersSales"></div>
                </div>
            </div>
        </div>

        <!-- Sales by Person Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Sales by Person</h2>
                    </div>
                    <div class="card-body" id="personSales"></div>
                </div>
            </div>
        </div>

        <!-- Sales Graph by Person Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Sales Graph by Person</h2>
                    </div>
                    <div class="card-body">
                        <canvas id="salesGraph"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overall Sales Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2>Overall Sales</h2>
                        <select class="custom-select" id="filter" style="width: 200px;">
                            <option value="today">Today</option>
                            <option value="last7days">Last 7 Days</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                    <div class="card-body">
                        <canvas id="overallSales"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="dashbord_script.js"></script>
</body>
</html>

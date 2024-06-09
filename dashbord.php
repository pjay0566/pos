<?php
include 'db.php';

// Determine the filter for overall sales
$filter = $_GET['filter'] ?? 'today';
$date_condition = "";

if ($filter == 'last7days') {
    $date_condition = "WHERE ih.create_date >= CURDATE() - INTERVAL 7 DAY";
} else if ($filter == 'month') {
    $date_condition = "WHERE MONTH(ih.create_date) = MONTH(CURDATE()) AND YEAR(ih.create_date) = YEAR(CURDATE())";
} else {
    $date_condition = "WHERE DATE(ih.create_date) = CURDATE()";
}

// Fetch overall sales by counter
$stmt = $pdo->prepare("SELECT IFNULL(c.counter_number, 'Unknown') as counter_number, SUM(ih.total) as total_sales
                       FROM invoice_header ih
                       LEFT JOIN counter c ON ih.icounter = c.icounter
                       GROUP BY c.icounter");
$stmt->execute();
$counters_sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch sales by user (person)
$stmt = $pdo->prepare("SELECT u.name, SUM(ih.total) as total_sales
                       FROM invoice_header ih
                       JOIN user u ON ih.create_user_id = u.user_id
                       GROUP BY u.user_id");
$stmt->execute();
$person_sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch sales data for graphs
$stmt = $pdo->prepare("SELECT u.name, SUM(ih.total) as total_sales
                       FROM invoice_header ih
                       JOIN user u ON ih.create_user_id = u.user_id
                       $date_condition
                       GROUP BY u.user_id");
$stmt->execute();
$sales_graph = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT DATE(ih.create_date) as sale_date, SUM(ih.total) as total_sales
                       FROM invoice_header ih
                       $date_condition
                       GROUP BY DATE(ih.create_date)");
$stmt->execute();
$overall_sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'counters_sales' => $counters_sales,
    'person_sales' => $person_sales,
    'sales_graph' => $sales_graph,
    'overall_sales' => $overall_sales
]);
?>

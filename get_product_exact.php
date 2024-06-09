<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pos";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $query = $_GET['query'];
    $sql = "SELECT iproduct_identity, product_name, price FROM product WHERE lower(product_name) = lower('$query') LIMIT 1";
    $result = $conn->query($sql);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode($data);

    $conn->close();
?>

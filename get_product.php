<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// $product_name=$_POST['product_name'];
$query = $_GET['query'];
$sql = "SELECT iproduct_identity, product_name, price FROM product WHERE product_name LIKE '%$query%' LIMIT 10";
$result = $conn->query($sql);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
// $suggestions = [];
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $suggestions[] = $row;
//     }
// }

echo json_encode($data);

$conn->close();
?>

<?php
session_start();
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

$data = json_decode(file_get_contents('php://input'), true);

// $invoice_no=$data['invoice_no'];

$payment_method=$data['payment_method'];
$subtotal=$data['subtotal'];
$tax=$data['tax'];
$total=$data['total'];
$create_user_id=$_SESSION['user_id'];
$counter_number = $_SESSION['counter_number'];

$sql = "INSERT INTO invoice(icounter,create_user_id,create_date,subtotal,tax,total,payment_method) 
    VALUES ('$counter_number','$create_user_id',now(),'$subtotal','$tax','$total','$payment_method')";

if ($conn->query($sql) === TRUE) {
    $iinvoice_no = $conn->insert_id;

    foreach ($data['details'] as $detail) {
        
        $iproduct_identity=$detail['iproduct_identity'];
        $product_name = $detail['product_name'];
        $qty = $detail['qty'];
        $price = $detail['price'];
        $totalprice=$detail['totalprice'];

        $sql = "INSERT INTO invoice_de (iinvoice_no, iproduct_identity,product_name,price, amount,quantity)
         VALUES ('$iinvoice_no','$iproduct_identity', '$product_name', '$price','$totalprice' ,'$qty')";
        $conn->query($sql);
    }

    echo $iinvoice_no;
} else {
    echo json_encode(['message' => 'Error saving invoice: ' . $conn->error]);
}

$conn->close();
?>
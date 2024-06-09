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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $store_name = $_POST['store_name'];
    $store_address = $_POST['store_address'];
    $gst_no = $_POST['gst_no'];
    mysqli_query($conn, 'TRUNCATE TABLE store');
    $sql = "INSERT INTO store (store_name, store_address, gst_no) 
    VALUES ('$store_name', REPLACE('$store_address','\n','<br/>'), '$gst_no')";

    if (mysqli_query($conn,$sql)) {
        echo "New store details saved successfully!";
		header("location: invoice_list.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    //$stmt->close();
}

$conn->close();
?>

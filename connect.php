<?php
function open_connection() {
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
    return $conn;
}
?>

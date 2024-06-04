<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '', 'pos') or die(mysqli_error($mysqli));

$create_user_id=mysqli_real_escape_string($mysqli,$_SESSION['user_id']);

if (isset($_POST['save_all'])) {
    $counter_numbers = $_POST['counter_numbers'];
    $date = date('Y-m-d H:i:s');

    $query = 'INSERT INTO counter (counter_number, create_user_id,create_date) 
     SELECT '. 
    join(" ,'$create_user_id','$date' UNION 
    SELECT ", $counter_numbers) . ", '$create_user_id','$date'";
  
    $mysqli->query('TRUNCATE TABLE counter;');
    $mysqli->query($query) or die($mysqli->error);
    header("location: coun_main.php");
}

if (isset($_GET['delete'])) {
    $counter_number = $_GET['delete'];
    $mysqli->query("DELETE FROM counter WHERE counter_number=$counter_number") or die($mysqli->error);
    header("location: coun_main.php");
}
?>

<?php

$conn = mysqli_connect('localhost','root','','pos');

if(!$conn)
{
    die('Connection Failed'.mysqli_connect_error());
}

?>
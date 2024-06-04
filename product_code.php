<?php
session_start();
require 'config.php';


if (isset($_POST['delete_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['delete_product']);

    $query = "DELETE FROM product WHERE product_name='$product_name' ";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Product Deleted Successfully";
        header("Location: product_list.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Product Not Deleted";
        header("Location: product_list.php");
        exit(0);
    }
}

if (isset($_POST['product_update'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $pname = mysqli_real_escape_string($conn, $_POST['pname']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $uom = mysqli_real_escape_string($conn, $_POST['uom']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    $last_update_user_id=$_SESSION['user_id'];

    $query = "UPDATE product SET product_name='$pname',product_description='$product_description',
    price='$price',cost='$cost',uom='$uom',last_update_user_id='$last_update_user_id',last_update_date='$date' 
    WHERE product_name='$product_name' ";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Product Updated Successfully";
        header("Location: product_list.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Product Not Updated";
        header("Location: product_list.php");
        exit(0);
    }

}


if (isset($_POST['save_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $uom = mysqli_real_escape_string($conn, $_POST['uom']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $create_user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
 
    $sql = "SELECT *from product where product_name='$product_name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION["message"] = "Product is Already Exist!";
        header("location: product_list.php");
    } else {
        $query = "INSERT INTO product (product_name,product_description,price,cost,uom,create_user_id,create_date) 
    VALUES ('$product_name','$product_description','$price','$cost','$uom','$create_user_id','$date')";

        $query_run = mysqli_query($conn, $query);
        if ($query_run) {
            $_SESSION['message'] = "Product Created Successfully";
            header("Location: product_list.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Product Not Created";
            header("Location: product_list.php");
            exit(0);
        }
    }
}
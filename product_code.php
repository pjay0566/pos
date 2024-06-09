<?php
session_start();
require 'config.php';

use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;


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

    $last_update_user_id=$_SESSION['user_id'];

    $query = "UPDATE product SET product_name='$pname',product_description='$product_description',
    price='$price',cost='$cost',uom='$uom',last_update_user_id='$last_update_user_id',last_update_date=now() 
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
    require 'vendor/autoload.php';

function generateBarcode($productName) {
    // Create a new instance of the BarcodeGenerator
    $generator = new BarcodeGeneratorPNG();

    // Generate a barcode using the product name
    $barcode = $generator->getBarcode($productName, $generator::TYPE_CODE_128);

    // Define the file path where the barcode image will be saved
    $filePath = 'barcode/' . preg_replace('/[^A-Za-z0-9]/', '', $productName) . '.png';
    
    $filePath1 = preg_replace('/[^A-Za-z0-9]/', '', time()) ;

    // Save the barcode as a PNG file
    file_put_contents($filePath, $barcode);
    // include 'config.php';
    // $sql="INSERT INTO product set create_user_id=19,product_name='$productName',barcode='$filePath1'";
    // Return the file path
    // $result=mysqli_query($conn,$sql);
    return $filePath1;
}

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);


    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $cost = mysqli_real_escape_string($conn, $_POST['cost']);
    $uom = mysqli_real_escape_string($conn, $_POST['uom']);
    $create_user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);
    
    $sql = "SELECT *from product where product_name='$product_name'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION["message"] = "Product is Already Exist!";
        header("location: product_list.php");
    } else {
        
    $barcode = generateBarcode($product_name);
    $barcodeimg='barcode/' . preg_replace('/[^A-Za-z0-9]/', '', $product_name) . '.png';

        $query = "INSERT INTO product (barcode,product_name,product_description,price,cost,uom,create_user_id,create_date,barimage) 
    VALUES ('$barcode','$product_name','$product_description','$price','$cost','$uom','$create_user_id',now(),'$barcodeimg')";

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
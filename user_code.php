<?php
session_start();
require 'config.php';

$options = 
    [ 
        'cost' => 10, 
        'salt' => '$6$rounds=5000$POS@2024$'
    ];

if(isset($_POST['delete_user']))
{
    $user_id = mysqli_real_escape_string($conn, $_POST['delete_user']);

    $query = "DELETE FROM user WHERE user_id='$user_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Deleted Successfully";
        header("Location: user_list.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Deleted";
        header("Location: user_list.php");
        exit(0);
    }
}

if(isset($_POST['user_update']))
{
    $user_id=mysqli_real_escape_string($conn, $_POST['user_id']);

    $name = mysqli_real_escape_string($conn, $_POST['uname']);

    $last_update_user_id=$_SESSION["user_id"];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $date=mysqli_real_escape_string($conn,$_POST['date']);
    // $password_hash=crypt($password, $options['salt']);

    $query = "UPDATE user SET name='$name',
    email='$email',mobile_number='$mobile_number',last_update_user_id='$last_update_user_id',last_update_date=now() 
    WHERE user_id='$user_id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['last_update_date']=$date;
        $_SESSION['message'] = "User Updated Successfully";
        header("Location: user_list.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "User Not Updated";
        header("Location: user_list.php");
        exit(0);
    }

}


if(isset($_POST['save_user']))
{
    $user_identity=mysqli_real_escape_string($conn,$_POST['uidentity']);
    $user_id=mysqli_real_escape_string($conn,$_POST['uid']);
    //$password=mysqli_real_escape_string($conn,$_POST['password']);
    $name = mysqli_real_escape_string($conn, $_POST['uname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile_number']);
    $create_user_id=mysqli_real_escape_string($conn,$_SESSION['user_id']);
    // $date=mysqli_real_escape_string($conn,$_POST['date']);
    // $last_update_user_id=$_SESSION['last_update_user_id'];
    $default_password="password@123";
    $hash_password=crypt($default_password, $options['salt']);

    $sql="SELECT *from user where user_id='$user_id' and name='$name'";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)>0)
    {
        $_SESSION["message"]="User is Already Exist !";
        header("location: user_list.php");
    }
    else
    {   
        $query = "INSERT INTO user (user_identity,user_id,password,name,email,mobile_number,create_user_id,create_date) 
        VALUES ('$user_identity','$user_id','$hash_password','$name','$email','$mobile_number','$create_user_id',now())";

        $query_run = mysqli_query($conn, $query);
        if($query_run)
        {
            $_SESSION['create_user_id']=$_SESSION['user_id'];
            $_SESSION['create_date']=$date;
            // $_SESSION['last_update_user_id']=$create_user_id;
            $_SESSION['message'] = "User Created Successfully";
            header("Location: user_list.php");
            exit(0);
        }
        else
        {
            $_SESSION['message'] = "User Not Created";
            header("Location: user_list.php");
            exit(0);
        }
    }
}
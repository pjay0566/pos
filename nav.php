<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <nav class="navbar">
        <div class="leftnavbar">
            <div class="logo">POS<sup style="font-size: 7px; top: -12px">beta</sup></div>
            <ul class="nav-links">
                <li><a href="invoice_main.php">Billing</a></li>
                <li><a href="product_list.php">Products</a></li>
                <li><a href="coun_main.php">Counter</a></li>
                <li><a href="user_list.php">Users</a></li>
                <li><a href="change_password.php">Change Password</a></li>

            </ul>
        </div>
        <div class="rightnavbar">
        <ul class="nav-links">
                <li>Counter Number : <?php echo $_SESSION['counter_number']; ?></li>
            </ul>
            <ul class="nav-links">
                <li>Hi, <?php echo $_SESSION['name']; ?></li>
                <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
            </ul>
        </div>
        <!-- <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div> -->
    </nav>
    <div style="height: 50px"></div>
</body>

</html>
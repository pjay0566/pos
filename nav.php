<?php 
    $url = str_replace('/pos%20project/', '', $_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="leftnavbar">
            <div class="logo">POS<sup style="font-size: 7px; top: -12px">beta</sup></div>
            <ul class="nav-links">
                <li class="<?= $url == 'invoice_list.php' ? 'active': '' ?>"><a href="invoice_list.php">Billing</a></li>
                <li class="<?= $url == 'product_list.php' ? 'active': '' ?>"><a href="product_list.php">Products</a></li>
                <li class="<?= $url == 'coun_main.php' ? 'active': '' ?>"><a href="coun_main.php">Counter</a></li>
                <li class="<?= $url == 'user_list.php' ? 'active': '' ?>"><a href="user_list.php">Users</a></li>
            </ul>
        </div>
        <div class="rightnavbar">
            <ul class="nav-links">
                <li>Counter: <?php echo $_SESSION['counter_number']; ?></li>
                <li>Hi, <?php echo $_SESSION['name']; ?></li>
                <li class="dropdown">
                    <div class="dropdown-label"><i class="fa fa-cog"></i></div>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="store_detail.php">Store Info</a>
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                        <a class="dropdown-item" href="logout.php"><span>Log out</span><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    </div>
                </li>
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
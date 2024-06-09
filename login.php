<?php
session_start();
//require 'config.php';
$useridRequired = "";
$passwordRequired = "";
$error = "";
include 'config.php';

if (isset($_POST['submit'])) {

	if (empty($_POST['username'])) {
		$useridRequired = "*Userid is Required";
	}

	if (empty($_POST['password'])) {
		$passwordRequired = "*Password is Required";
	}

	$options =
		[
			'cost' => 10,
			'salt' => '$6$rounds=5000$POS@2024$'
		];

	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$dbname = 'pos';
	$conn = mysqli_connect($host, $user, $pass, $dbname);
	if (!$conn) {
		die('could not connect:' . mysqli_connect_error());
	}
	$uname = $_POST['username'];
	$password = $_POST['password'];

	$hashedPassword = crypt($password, $options['salt']);

	// echo 'POFuvpNBSv7NM <br>';
	// echo $password.'<br/>';
	// echo $hashedPassword;

	$sql = "SELECT * FROM user where user_id = '$uname' and password = '$hashedPassword'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		$error = '';
		$_SESSION['counter_number'] = $_POST['counter_number'];
		while ($row = mysqli_fetch_assoc($result)) {
			//echo $row['user_id'];
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['name'] = $row['name'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['mobile_number'] = $row['mobile_number'];
			$_SESSION['password'] = $row['password'];

			header('Location: user_list.php');
			exit();
		}
	} else if ($useridRequired == '' && $passwordRequired == '') {
		$error = 'Invalid credentials';
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
		rel="stylesheet">
	<style>

		body {
			overflow: hidden;
		}
		.error {
			color: #FF0000;
		}

		* {
			font-family: "Hanken Grotesk", sans-serif;
		}

		form {
			border: 3px solid #7e42f5 width:100%;
		}

		input[type="text"],
		input[type="password"] {

			padding: 12px 20px;
			border-top-right-radius: 4px;
			border-top-left-radius: 4px;

			border: 1px solid #ccc;
			box-sizing: border-box;
		}

		input[type="submit"]:hover {
			background-color: #6121ad;
			opacity: 0.8;
		}

		input[type="submit"] {
			width: 100%;
			border-radius: 5px;
			color: #fff;
			border: none;
			text-align: center;
			transition-duration: 0.6s;
			cursor: pointer;
			background-color: #6121ad;
			font-weight: 700;
			height: 50px;
		}

		/* div {
			margin: auto;
			opacity: 0.9;
			height: 300px;
			width: 25%;
			padding: 30px;
			line-height: 10px;
		} */

		select {
			margin: 10px;
			padding: 5px;
			border-radius: 5px;
		}

		@media screen and (max-width:400px) {
			display:block;
			float:right;
		}

		.align-right {
			display: flex;
			justify-content: flex-end;
		}

		.align-left {
			display: flex;
			justify-content: flex-start;
			align-items: flex-start;
		}

		.align-center {
			display: flex;
			justify-content: flex-start;
			align-items: center;
		}

		.flex-1 {
			display: flex;
			align-items: stretch;
			height: 100vh;
			width: 100%;
		}

		.flex {
			display: flex;
		}

		.padding-100 {
			padding: 100px;
		}

		.border-box {
			box-sizing: border-box;
		}

		.flex-direction-column {
			flex-direction: column;
		}

		.width-100 {
			width: 100%;
		}

		.position-relative {
			position: relative;
		}

		.login-bg {
			position: absolute;
			opacity: 0.12;
			z-index: 0;
		}

		.login-bg img {
			width: 100%;
			object-fit: cover;
		}

		.login-content {
			z-index: 1;
			position: relative;
			color: #444;
			font-weight: 600;
		}

		.banner-1 {
			position: absolute;
			background-color: orange;
			top: -38px;
			transform: rotate(160deg);
			width: 100%;
			height: 50px;
			left: -134px;
			z-index: 0;
		}

		.banner-2 {
			position: absolute;
			background-color: white;
			top: 0px;
			transform: rotate(160deg);
			width: 100%;
			height: 50px;
			left: -134px;
			z-index: 0;
		}

		.banner-3 {
			position: absolute;
			background-color: green;
			top: 38px;
			transform: rotate(160deg);
			width: 100%;
			height: 50px;
			left: -134px;
			z-index: 0;
		}
	</style>
</head>

<body class="flex">
	<div class="row flex-1 border-box">
		<div class="col-md-8 align-center border-box position-relative" style="border-right: solid 1px #dedede; 
		z-index: 2;
    	background: #fff;">
			<div class="login-bg"><img src="loginbg.jpeg" /></div>
			<div class="align-left flex-direction-column width-100 padding-100 login-content">
				<h1>POS<sup style="font-size: 10px; top: -10px; position: relative;">beta</sup></h1>
				<div style="border-bottom: solid 1px #dedede; height: 10px; width: 100%"></div>
				<div style="height: 300px">
					<br>
					Welcome to the POS System! Your partner in seamless and efficient transactions.<br><br>
					<ul style="padding: 0px 40px">
						<li>
							Scheduled Maintenance: Our system will be undergoing maintenance every week.
						</li>
						<li>
							Please save your work and log out beforehand.
						</li>
						<li>
							Tip of the Day: Remember to close out your cash drawer at the end of each shift to ensure
							accurate reporting.
						</li>
						<li>
							Need Help? Contact our support team.
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-4 align-center border-box position-relative" style="padding-left: 100px">
			<div class="banner-1"></div>
			<div class="banner-2"></div>
			<div class="banner-3"></div>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
				<h4>Log in to</h4><br>
				<input type="text" name="username" placeholder="username"><br>
				<span class="error"><?php echo $useridRequired; ?> </span><br>
				<input type="password" name="password" placeholder="password"><br>
				<span class="error"><?php echo $passwordRequired; ?></span><br>
				Select Counter
				<select name="counter_number">
					<?php
					$sql = "SELECT counter_number from counter";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							echo "<option value='{$row['counter_number']}'>{$row['counter_number']}</option>";
						}
					}
					?>
				</select><br>
				<span class="error"><?php echo $error; ?></span><br>
				<input type="submit" name="submit" value="Log in">
			</form>
		</div>
	</div>
</body>

</html>
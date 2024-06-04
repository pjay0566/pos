<?php
session_start();
require 'connect.php'; 
include 'nav.php';

$errors = '';
$success_message = '';
$options = ['cost' => 10, 'salt' => '$6$rounds=5000$POS@2024$'];

if (isset($_POST['btnChangePassword'])) {
	// Fetch the user's current password from the database
	$conn = open_connection();

	$old_password = mysqli_real_escape_string($conn, $_POST['old_password']);
	$new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
	$confirm_new_password = mysqli_real_escape_string($conn, $_POST['confirm_new_password']);
	$hashed_password = crypt($old_password, $options['salt']);
	$user_id = mysqli_real_escape_string($conn, $_SESSION['user_id']);

	// Check if new password and confirm new password match
	if ($new_password !== $confirm_new_password) {
		$errors = $errors . "New password and confirm new password do not match. <br/>";
	}

	$sql = "SELECT user_id FROM user WHERE user_id = '$user_id' and password = '$hashed_password'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0 and $errors == '') { // if row count is > 0 than the old password entered is valid
		$new_hashed_password = crypt($new_password, $options['salt']);

		$sql2 = "UPDATE user 
					SET password = '$new_hashed_password', 
						last_update_user_id = '$user_id',
						last_update_date = now()
					WHERE user_id = '$user_id'";

		if (mysqli_query($conn, $sql2)) {
			$errors = '';
			$success_message = "password updated successfully";
			header('location: user_list.php');
		} else {
			$errors = "password not updated";
		}
	} else {
		$errors = $errors . "Old password is incorrect. <br/>";
	}

	$conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Change Password</title>
		<style>
			.main-panel {
				width: 30%;
				box-sizing: border-box;
				margin: 100px auto;
			}
		</style>
	</head>
	<body>
		<div class="main-panel">
			<h4>Change Password</h4>
			<br>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
				<label for="old_password">Old Password:</label><br>
				<input type="password" id="old_password" name="old_password" required><br><br>
				<label for="new_password">New Password:</label><br>
				<input type="password" id="new_password" name="new_password" required><br><br>
				<label for="confirm_new_password">Confirm New Password:</label><br>
				<input type="password" id="confirm_new_password" name="confirm_new_password" required><br><br>
				<div style="color: #00ff00;"><?php echo $success_message; ?></div>
				<div style="color: #ff0000;"><?php echo $errors; ?></div>
				<button name="btnChangePassword" type="submit" class="btn btn-primary">Change Password</button>
			</form>
		</div>
	</body>
	<?php include 'footer.php'; ?>
</html>
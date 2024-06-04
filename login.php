<?php
 session_start();
 //require 'config.php';
 $useridRequired=" ";
 $passwordRequired=" ";
 $error="";
 include'config.php';

if(isset($_POST['submit']))
{

	if(empty($_POST['username']))
	{
		$useridRequired="*Userid is Required";
	}
	
	if(empty($_POST['password']))
	{
		$passwordRequired="*Password is Required";
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
	$conn = mysqli_connect($host,$user,$pass,$dbname);
	if(!$conn)
	{
		die('could not connect:'.mysqli_connect_error());
	}
	$uname=$_POST['username'];
	$password=$_POST['password'];

	$hashedPassword = crypt($password, $options['salt']);

	// echo 'POFuvpNBSv7NM <br>';
	// echo $password.'<br/>';
	// echo $hashedPassword;

	$sql = "SELECT * FROM user where user_id = '$uname' and password = '$hashedPassword'";
	$result = mysqli_query($conn, $sql);
	
	if(mysqli_num_rows($result) > 0)
	{ 
		$error = '';
		$_SESSION['counter_number']=$_POST['counter_number'];
		while($row = mysqli_fetch_assoc($result))
		{
			//echo $row['user_id'];
			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['username']=$row['username'];
			$_SESSION['name']=$row['name'];
			$_SESSION['email']=$row['email'];
			$_SESSION['mobile_number']=$row['mobile_number'];
			$_SESSION['password']=$row['password'];

			header('Location: user_list.php');
			exit();
		}
	} else {
		$error = 'Invalid credentials';
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
	<style>
		.error {color: #FF0000;}

		* {
			font-family: "Roboto", sans-serif;
		}
form
{
	border: 3px solid #7e42f5
	width:100%;
}

input[type="text"],input[type="password"]
{
	
  padding: 12px 20px;
  margin: 8px 0;
  border-top-right-radius: 4px;
  border-top-left-radius: 4px;
 
  border: 1px solid #ccc;
  box-sizing: border-box;
}
input[type="submit"]:hover
{
	background-color:#867979;
	opacity:0.5;
}
input[type="submit"]
{
	width:50%;
	border-radius:5px;
	color:black;
    border:none;
	text-align:center;
	transition-duration:0.6s;
	cursor:pointer;
	background-color:#e5e8cc;
	font-weight: 700;
	height: 50px;
}
div
{
	background-color:#41769e;
	opacity:0.9;
	height:300px;
	width:28%;
	padding: 30px;
}
@media screen and (max-width:400px)
{
	display:block;
	float:right;
	
}
	</style>
</head>
<body>
	<center>
		<div>
	<h4>WELCOME</h4>
			
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
					<input type="text" name="username"  placeholder="username"><br>
					<span class="error"><?php echo $useridRequired;?> </span><br>
						<input type="password" name="password" placeholder="password"><br>
						Select Counter<select style="margin-top: 20px" name="counter_number">
						<?php
							$sql="SELECT counter_number from counter";
							$result=mysqli_query($conn,$sql);
							if(mysqli_num_rows($result)>0)
							{
								while($row=mysqli_fetch_assoc($result))
								{
									echo"<option value='{$row['counter_number']}'>{$row['counter_number']}</option>";
								}
							}				
						?>
						</select>
						<span class="error"><?php echo $passwordRequired;?></span><br>
						<span class="error"><?php echo $error;?></span><br>
						<br><input type="submit" name="submit" value="Log in">
				</form>
		</div>
	</center>
</body>
</html>
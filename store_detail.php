<?php
	session_start();
	include 'nav.php';
	$mysqli = new mysqli('localhost', 'root', '', 'pos') or die(mysqli_error($mysqli));
	$result = $mysqli->query("SELECT store_name, REPLACE(store_address,'<br/>','\n') as store_address, gst_no FROM store") or die($mysqli->error);
    $row = $result->fetch_assoc();
    $store_name = $row["store_name"];
    $store_address = $row["store_address"];
    $gst_no = $row["gst_no"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Details Form</title>
    <style>
        body {
            font-family: "Hanken Grotesk", sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
			
		}
        .container {
            background-color: #fff;
            padding: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
			width:25%;
            top: 100px;
            position: relative;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group textarea,
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group button {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Store Details</h2>
        <form action="save_store.php" method="post">
            <div class="form-group">
                <label for="store_address">Store Name:</label>
                <input type="text" name="store_name" id="store_name" required value="<?=$store_name?>"></input>
            </div>
            <div class="form-group">
                <label for="store_address">Store Address:</label>
                <textarea name="store_address" id="store_address" rows="4" required><?=$store_address?></textarea>
            </div>
            <div class="form-group">
                <label for="gst_no">GST No:</label>
                <input type="text" name="gst_no" id="gst_no" maxlength="15" required value="<?=$gst_no?>">
            </div>
            <div class="form-group">
                <button type="submit">Save</button>
            </div>
        </form>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>

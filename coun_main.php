<?php
	session_start();
	include 'nav.php';
	$mysqli = new mysqli('localhost', 'root', '', 'pos') or die(mysqli_error($mysqli));
	$result = $mysqli->query("SELECT * FROM counter") or die($mysqli->error);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System Counter</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style_list.css">
    <link rel="stylesheet" href="coun_css.css">
</head>
<body>
    <div class="container">
        <h1>POS System Counter</h1>
        
        <form action="coun_process.php" method="POST" id="counterForm">
			<div class="header-row">
				<div>Counter Name</div>
				<div>Actions</div>
			</div>
            <div id="inputContainer">
				<?php while ($row = $result->fetch_assoc()): ?>
					<div class="input-group">
						<input type="number" name="counter_numbers[]" placeholder="Enter counter number" required value="<?php echo $row['counter_number']; ?>">
                    	<a href="coun_process.php?delete=<?php echo $row['counter_number']; ?>" class="btn">Remove</a>
					</div>
				<?php endwhile; ?>
                <div class="input-group">
                    <input type="number" name="counter_numbers[]" placeholder="Enter counter number" required value="">
					<a href="javascript:void(0)" class="btn" onclick="removeInput(this)">Remove</a>
                </div>
            </div>
            <button type="button" class="btn" onclick="addInput()">Add</button>
            <button type="submit" name="save_all" class="btn">Save</button>
        </form>
    </div>

    <script>
        function addInput() {
            const inputContainer = document.getElementById('inputContainer');
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group';
            newInputGroup.innerHTML = `
                <input type="number" name="counter_numbers[]" placeholder="Enter counter number" required>
                <button type="button" class="btn remove-btn" onclick="removeInput(this)">Remove</button>
            `;
            inputContainer.appendChild(newInputGroup);
        }

        function removeInput(button) {
            button.parentElement.remove();
        }
    </script>
</body>
<?php include 'footer.php'; ?>
</html>

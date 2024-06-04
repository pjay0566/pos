<?php
session_start();
require 'config.php';
include 'nav.php';
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Edit</title>
</head>
<body>
  
    <div class="container mt-3">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Edit 
                            <a href="user_list.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $user_id = mysqli_real_escape_string($conn, $_GET['id']);

                            $query = "SELECT * FROM user WHERE user_id='$user_id' ";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $user = mysqli_fetch_array($query_run);
                                ?>
                                <form action="user_code.php" method="POST">
                                <input type="hidden" name="user_id" value="<?= $user['user_id']; ?>">    
                                    <div class="mb-2">
                                        <input type="hidden" name="uidentity" value="<?=$user['user_identity'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>User Id</label>
                                        <input type="text" name="uid" value="<?=$user['user_id'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>UserName</label>
                                        <input type="text" name="uname" value="<?=$user['name'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>Email</label>
                                        <input type="email" name="email" value="<?=$user['email'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>Mobile_Number</label>
                                        <input type="text" name="mobile_number" value="<?=$user['mobile_number'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>Date</label>
                                        <input type="date" name="date" value="<?=$user['create_date'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" name="user_update" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>

                                </form>
                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="confirm.js"></script>
</body>
<?php
include'footer.php';

?>
</html>
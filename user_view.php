<?php
session_start();
require 'config.php';
include 'nav.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style type="text/css">
        .container {
            margin-top: 1%;
            width: 400px;
            border: ridge 1.5px white;
            padding: 20px 0 20px 20px;
        }

        body {
            background: #FFF;
            /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #FFF, #FFF);
            /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #FFF, #FFF);
            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        .btn {
            margin: 0 0 0 170px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h4>User Detail
            <a href="user_list.php" class="btn btn-danger ">BACK</a>
        </h4>
        <?php
        if (isset($_GET['id'])) {
            $user_id = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "SELECT * FROM user WHERE user_id='$user_id' ";
            $query_run = mysqli_query($conn, $query);

            if (mysqli_num_rows($query_run) > 0) {
                $user = mysqli_fetch_array($query_run);
                ?>
                <div class="mb-2">
                    <label>UserId</label>
                    <p class="form-control">
                        <?= $user['user_id']; ?>
                    </p>
                </div>
                <div class="mb-2">
                    <label>Username</label>
                    <p class="form-control">
                        <?= $user['name']; ?>
                    </p>
                </div>
                <div class="mb-2">
                    <label>Email</label>
                    <p class="form-control">
                        <?= $user['email']; ?>
                    </p>
                </div>
                <div class="mb-2">
                    <label>Mobile Number</label>
                    <p class="form-control">
                        <?= $user['mobile_number']; ?>
                    </p>
                </div>
                <div class="mb-2">
                    <label>Create User Id</label>
                    <p class="form-control">
                        <?= $user['create_user_id']; ?>
                    </p>
                </div>
                <div class="mb-2">
                    <label>Date</label>
                    <p class="form-control">
                        <?= $user['create_date']; ?>
                    </p>
                </div>
                <div class="mb-2">
                    <label>Last Update User Id</label>
                    <p class="form-control">
                        <?= $user['last_update_user_id']; ?>
                    </p>
                </div>
                <div class="mb-2">
                    <label>Last Update Date</label>
                    <p class="form-control">
                        <?= $user['last_update_date']; ?>
                    </p>
                </div>
                <?php
            } else {
                echo "<h4>No Such Id Found</h4>";
            }
        }
        ?>
    </div>
</body>
<?php
include 'footer.php';
?>

</html>
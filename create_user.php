<?php
session_start();
include 'nav.php';
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="style_form.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>User Create</title>
</head>

<body>

    <div class="container mt-4">

        <?php include ('message.php'); ?>
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4>User Add
                            <a href="user_list.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="user_code.php" method="POST">
                            <div class="row jumbotron box8">
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="user_identity">User Identity</label>
                                    <input type="text" class="form-control" name="uidentity" id="user_identity"
                                        placeholder="Enter User Identity." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="user_id">User Id</label>
                                    <input type="text" class="form-control" name="uid" id="user_id"
                                        placeholder="Enter User Id." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="uname" id="username"
                                        placeholder="Enter Username." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Enter Your Email ID." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="mobile">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile_number" id="mobile"
                                        placeholder="Enter Your Mobile Number." required>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" name="save_user" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<?php
    include 'footer.php';
?>
</html>
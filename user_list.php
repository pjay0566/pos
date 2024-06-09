<?php
session_start();
require 'config.php';
include 'nav.php';

$sort_order = 'ASC';
$sort_by = 'name';
$items_per_page = 10;
$page = 1;
$search_query = '';

if (isset($_GET['order']) && $_GET['order'] == 'DESC') {
    $sort_order = 'DESC';
}

if (isset($_GET['sort_by']) && in_array($_GET['sort_by'], ['name'])) {
    $sort_by = $_GET['sort_by'];
}

if (isset($_GET['items_per_page']) && is_numeric($_GET['items_per_page'])) {
    $items_per_page = $_GET['items_per_page'];
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
}

if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$offset = ($page - 1) * $items_per_page;

$sql_count = "SELECT COUNT(*) as total FROM user WHERE name LIKE '%$search_query%'";
$result_count = $conn->query($sql_count);
$total_rows = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $items_per_page);

$sql = "SELECT * FROM user WHERE  CONCAT(user_id,name,email) LIKE '%$search_query%' ORDER BY $sort_by $sort_order LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style_list.css">
    <title>User CRUD</title>
</head>

<body>

    <div class="container mt-4">
        <center>
        <form method="GET" action=""
            style="display: flex; flex-direction: row; justify-content: center; align-items: center; margin-bottom: 20px;">
            <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
            Search: &nbsp;
            <input type="text" name="search">
            <button type="submit" class="btn btn-primary"
                style="margin-left: 20px; height: 28px; display: flex; justify-content: center; align-items: center;">Go</button>
        </form>
        </center>
        <?php include ('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>User Details
                            <a href="create_user.php" class="btn btn-primary float-end"><i
                                    class="fa-solid fa-user-plus"></i> Add User</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <?php
                                    $new_order = $sort_order == 'ASC' ? 'DESC' : 'ASC';
                                    ?>
                                    <th><a
                                            href="?sort_by=user_id&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">UserID</a>
                                    </th>
                                    <th><a
                                            href="?sort_by=name&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Username</a>
                                    </th>
                                    <th><a
                                            href="?sort_by=last_update_date&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Last_Update_Date</a>
                                    </th>
                                    <th><a
                                            href="?sort_by=email&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Email</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        foreach ($result as $user) {
                                            ?>
                                            <tr>
                                                <td><?= $user['user_id']; ?></td>
                                                <td><?= $user['name']; ?></td>
                                                <td><?= $user['last_update_date']; ?></td>
                                                <td><?= $user['email']; ?></td>

                                                <td>
                                                    <a href="user_view.php?id=<?= $user['user_id']; ?>"
                                                        class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                                                    <a href="user_edit.php?id=<?= $user['user_id']; ?>"
                                                        class="btn btn-success btn-sm"><i
                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                    <form action="user_code.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_user" value="<?= $user['user_id']; ?>"
                                                            class="btn btn-danger btn-sm"><i
                                                                class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        echo "<h5> No Record Found </h5>";
                                    }
                                if (isset($_POST['search'])) {
                                    $filtervalues = $_POST['search'];
                                    $query = "SELECT * FROM user WHERE CONCAT(user_id,name,email) LIKE '%$filtervalues%' ";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $items) {
                                            ?>
                                            <tr>
                                                <td><?= $items['user_id']; ?></td>
                                                <td><?= $items['name']; ?></td>
                                                <td><?= $items['last_update_date']; ?></td>
                                                <td><?= $items['email']; ?></td>

                                                <td>
                                                    <a href="user_view.php?id=<?= $items['user_id']; ?>"
                                                        class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                                                    <a href="user_edit.php?id=<?= $items['user_id']; ?>"
                                                        class="btn btn-success btn-sm"><i
                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                    <form action="user_code.php" method="POST" class="d-inline">
                                                        <button type="submit" name="delete_user" value="<?= $items['user_id']; ?>"
                                                            class="btn btn-danger btn-sm"><i
                                                                class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="4">No Record Found</td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
<div class="pagination">
<?php
// Display pagination links
if ($total_pages > 1) {
    echo '<a class="rounded-button"href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page=1&search_query='.$search_query.'">First</a> ';
    if ($page > 1) {
        echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page='.$page-1 . '&search_query='.$search_query.'">Previous</a> ';
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<a class="rounded-button active">' . $i . '</a> ';
        } else {
            echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page='. $i.' &search_query='.$search_query.'">' . $i . '</a> ';
        }
    }
    if ($page < $total_pages) {
        echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page='. $page+1 .' &search_query='.$search_query.'">Next</a> ';
    }
    echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page=' . $total_pages . '&search_query=' .$search_query. '">Last</a> ';
}
?>
    <form method="GET" action="" style="margin-left: 50px;">
        <label for="recordsPerPage">Show:</label>
        <select name="items_per_page" id="items_per_page" onchange="this.form.submit()">
            <option value="5" <?php if ($items_per_page == 5)
                echo 'selected'; ?>>5</option>
            <option value="10" <?php if ($items_per_page == 10)
                echo 'selected'; ?>>10</option>
            <option value="25" <?php if ($items_per_page == 25)
                echo 'selected'; ?>>25</option>
            <option value="50" <?php if ($items_per_page == 50)
                echo 'selected'; ?>>50</option>
        </select>
    </form> 
</div>
<div style="margin: 40px"></div>
    
<?php include 'footer.php'; ?>

</html>
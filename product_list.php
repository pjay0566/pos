<?php
session_start();
require 'config.php';
include 'nav.php';

$sort_order = 'ASC';
$sort_by = 'product_name';
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

$sql_count = "SELECT COUNT(*) as total FROM product WHERE product_name LIKE '%$search_query%'";
$result_count = $conn->query($sql_count);
$total_rows = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $items_per_page);

$sql = "SELECT * FROM product WHERE  CONCAT(product_name,product_description,price,cost) LIKE '%$search_query%' ORDER BY $sort_by $sort_order LIMIT $items_per_page OFFSET $offset";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="style_list.css">
    <title>Product CRUD</title>
</head>

<body>

    <div class="container mt-4">
        <center>
            <form method="GET" action="">
                <label for="recordsPerPage">Records per page:</label>
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
                <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
                Search :
                <input type="text" name="search" placeholder="Search User">

                <button type="submit" class="btn btn-primary">Go</button>
            </form>
        </center>
        <?php include ('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Details
                            <a href="create_product.php" class="btn btn-primary float-end"><i
                                    class="fa-solid fa-user-plus"></i> Add Product</a>
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
                                            href="?sort_by=product_name&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Product
                                            Name</a></th>
                                    <th><a
                                            href="?sort_by=product_description&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Product
                                            Description</a></th>
                                    <th><a
                                            href="?sort_by=price&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Price</a>
                                    </th>
                                    <th><a
                                            href="?sort_by=cost&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Cost</a>
                                    </th>
                                    <th><a
                                            href="?sort_by=uom&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">UOM</a>
                                    </th>
                                    <th><a
                                            href="?sort_by=action&order=<?php echo $new_order; ?>&items_per_page=<?php echo $items_per_page; ?>&page=<?php echo $page; ?>&search_query=<?php echo $search_query; ?>">Action</a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    foreach ($result as $product) {
                                        ?>
                                        <tr>
                                            <td><?= $product['product_name']; ?></td>
                                            <td><?= $product['product_description']; ?></td>
                                            <td><?= $product['price']; ?></td>
                                            <td><?= $product['cost']; ?></td>
                                            <td><?= $product['uom']; ?></td>
                                            <td>
                                                <a href="product_view.php?product_name=<?= $product['product_name']; ?>"
                                                    class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                                                <a href="product_edit.php?product_name=<?= $product['product_name']; ?>"
                                                    class="btn btn-success btn-sm"><i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                <form action="product_code.php" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_product"
                                                        value="<?= $product['product_name']; ?>" class="btn btn-danger btn-sm"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<h5> No Record Found </h5>";
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
        echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page='.$page-1 . '&search_query='.$search_query.'"><i class="fa-solid fa-arrow-left"></i></a> ';
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<a class="rounded-button">' . $i . '</a> ';
        } else {
            echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page='. $i.' &search_query='.$search_query.'">' . $i . '</a> ';
        }
    }
    if ($page < $total_pages) {
        echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page='. $page+1 .' &search_query='.$search_query.'"><i class="fa-solid fa-arrow-right"></i></a> ';
    }
    echo '<a class="rounded-button" href="?sort_by=' . $sort_by . '&items_per_page=' . $items_per_page . '&page=' . $total_pages . '&search_query=' .$search_query. '">Last</a> ';
}
?>
    </div>
<?php include 'footer.php'; ?>

</html>
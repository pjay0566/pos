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
    <title>Product Edit</title>
</head>
<body>
  
    <div class="container mt-3">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Edit 
                            <a href="product_list.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['product_name']))
                        {
                            $product_name = mysqli_real_escape_string($conn, $_GET['product_name']);

                            $query = "SELECT * FROM product WHERE product_name='$product_name' ";
                            $query_run = mysqli_query($conn, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $product = mysqli_fetch_array($query_run);
                                ?>
                                <form action="product_code.php" method="POST">
                                <input type="hidden" name="product_name" value="<?= $product['product_name']; ?>">    
                                    <div class="mb-2">
                                        <label>Product Name</label>
                                        <input type="text" name="pname" value="<?=$product['product_name'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>Product Description</label>
                                        <textarea name="product_description" value="<?=$product['product_description'];?>" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Price</label>
                                        <input type="number" name="price" value="<?=$product['price'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>Cost</label>
                                        <input type="number" name="cost" value="<?=$product['cost'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <label>UOM:</label>
                                        <input type="text" name="uom" value="<?=$product['uom'];?>" class="form-control">
                                    </div>
                                    <div class="mb-2">
                                        <button type="submit" name="product_update" class="btn btn-primary">
                                            Update
                                        </button>
                                    </div>

                                </form>
                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such product Found</h4>";
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
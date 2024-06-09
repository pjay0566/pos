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

    <title>Product Create</title>
</head>

<body>

    <div class="container mt-4">

        <?php include ('message.php'); ?>
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Add
                            <a href="product_list.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="product_code.php" method="POST">
                            <div class="row jumbotron box8">
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="iproduct_identity">Product Identity</label>
                                    <input type="number" class="form-control" name="pidentity" id="iproduct_identity"
                                        placeholder="Enter Product Identity." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                        placeholder="Enter Product Name." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="product_description">Product Description</label>
                                    <textarea class="form-control" name="product_description" id="product_description"
                                        placeholder="Enter Product Description." required></textarea>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="price">Price</label>
                                    <input type="number" class="form-control" name="price" id="price"
                                        placeholder="Enter Price." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="cost">Cost</label>
                                    <input type="number" class="form-control" name="cost" id="cost"
                                        placeholder="Enter Cost." required>
                                </div>
                                <div class="col-sm-6 mb-4 form-group">
                                    <label for="uom">UOM:</label>
                                    <input type="text" class="form-control" name="uom" id="uom"
                                        placeholder="Enter Unit Of Major." required>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" name="save_product" class="btn btn-primary">Save</button>
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
include'footer.php';
?>
</html>
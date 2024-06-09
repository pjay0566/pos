<?php
session_start();
include 'nav.php';

include 'config.php';
// // Database connection details
// $host = 'localhosT';
// $dbname = 'pos';
// $username = 'root';
// $password = '';
$current_date = date('Y-m-d H:i:s');

// try {
//     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Could not connect to the database: " . $e->getMessage());
// }

// // Function to generate the next invoice number
// function generateInvoiceNumber($pdo, $prefix, $maxLength)
// {
//     // Fetch the last invoice number
//     $stmt = $pdo->query("SELECT iinvoice_no FROM invoice_header ORDER BY iinvoice_no DESC LIMIT 1");
//     $lastInvoice = $stmt->fetch(PDO::FETCH_ASSOC);

//     if ($lastInvoice) {
//         $lastInvoiceNumber = $lastInvoice['iinvoice_no'];
//         // Remove the prefix and increment the number
//         $lastNumber = (int) str_replace($prefix, '', $lastInvoiceNumber);
//         $nextNumber = $lastNumber + 1;
//     } else {
//         // No previous invoice number, start with 1
//         $nextNumber = 1;
//     }

//     // Format the next invoice number with the prefix and ensure it is less than 5 digits
//     $nextInvoiceNumber = $prefix . str_pad($nextNumber, $maxLength - strlen($prefix), '0', STR_PAD_LEFT);

//     // Ensure the total length is less than or equal to maxLength
//     if (strlen($nextInvoiceNumber) > $maxLength) {
//         throw new Exception("Generated invoice number exceeds the maximum length");
//     }

//     return $nextInvoiceNumber;
// }

// // Usage example
// try {
//     $prefix = 'INV'; // Define your prefix here
//     $maxLength = 6; // Total length of the invoice number including the prefix

//     $newInvoiceNumber = generateInvoiceNumber($pdo, $prefix, $maxLength);

// } catch (Exception $e) {
//     echo "Error: " . $e->getMessage();
// }


// // Get a new invoice number

// // Close the connection


// ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Page</title>
    <link rel="stylesheet" href="invoice_css.css">
</head>

<body>
    <div class="row">
        <div class="col-md-9 padding-40">
            <div class="invoice-header">
                <div style="display: flex; justify-content: space-between;">
                    <h3 style="margin-bottom: 50px">INVOICE</h3>

                    <div class="align-left">Invoice No :<?php echo $_GET['invoice_no']; ?></div>
                    <div>
                        <div class="align-right">Counter Number :<?php echo $_SESSION['counter_number']; ?></div>
                        <div class="align-right">
                            <?php
                            $sql = "SELECT create_date from invoice_header where iinvoice_no={$_GET['invoice_no']}";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "{$row['create_date']}";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!--<div class="col-md-2">
                    Invoice No:--> <input type="hidden" id="invoice_no" name="invoice_no"
                    value="<?php echo $newInvoiceNumber; ?>" readonly>
                <!--  </div> -->
                <!-- <div>
                        <label for="date">Date:</label>
                    <input type="date" id="date" name="create_date">
                </div>
                <div>
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" id="customer_name" name="customer_name">
                </div>
                <div>
                    <label for="counter_no">Counter No:</label>
                    <select id="counter_no" name="counter_number">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div> -->
            </div>
            <div class="invoice-details">
                <h5>ITEMS</h5>
                <table id="invoice_table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            <!-- <th>Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>


                            <?php
                            $invoice_no = $_GET['invoice_no'];
                            $sql2 = "SELECT * from invoice_detail where iinvoice_no='$invoice_no'";
                            $result = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($result) > 0) {
                                foreach ($result as $row) {
                                    // echo"helo";
                                    ?>
                                <tr>
                                    <td style="text-align: center">
                                        1 <input type="hidden" class="iproduct_identity">
                                    </td>
                                    <td class="product_autocomplete">
                                        <input type="text" class="product_name" name="product_name[]"
                                            value="<?= $row['product_name']; ?>" readonly>
                                    </td>
                                    <td><input type="number" class="qty" onkeyup="calculateProductTotal(this)" name="qty[]"
                                            min="1" value="<?= $row['quantity']; ?>" readonly></td>
                                    <td><input type="number" class="price" onkeyup="calculateProductTotal(this)" name="price[]"
                                            value="<?= $row['price']; ?>" readonly>
                                    </td>
                                    <td><input type="number" class="totalprice" name="totalprice[]"
                                            value="<?= $row['amount']; ?>" readonly></td>
                                </tr>
                                <?php
                                }
                            }
                            ?>


                        <!-- ?> -->
                        <!-- <td class="align-center">
                                <button class="delete btn btn-danger btn-sm"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="invoice-actions">
                        <button id="add_row" style="width: 100%;visibility: hidden; margin: 10px 0px;">Add New
                            Row</button>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row margin-bottom-5">
                        <?php
                        $invoice_no = $_GET['invoice_no'];
                        $sql2 = "SELECT *from invoice_header where iinvoice_no='$invoice_no'";
                        $result = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $row) {
                                ?>
                                <div class="col-md-6 align-right">Subtotal:</div>
                                <div class="col-md-6"><input type="text" id="subtotal" name="subtotal" value="<?= $row['subtotal']; ?>" readonly></div>
                            </div>
                            <div class="row margin-bottom-5">
                                <div class="col-md-6 align-right">Tax (GST):</div>
                                <div class="col-md-6"><input type="text" id="tax" name="tax" value="<?= $row['tax']; ?>" readonly></div>
                            </div>
                            <div class="row margin-bottom-5">
                                <div class="col-md-6 align-right">Total:</div>
                                <div class="col-md-6"><input type="text" id="total" name="total" value="<?= $row['total']; ?>" readonly></div>
                            </div>
                            <div class="row margin-bottom-5">
                                <div class="col-md-6 align-right">Payment Method:</div>
                                <div class="col-md-6"><select name="payment_method" id="payment_method"  disabled>
                                        <option value="<?= $row['payment_method']; ?>" ><?php echo $row['payment_method']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <?php
                            }
                        }
                        ?>
                    <div class="invoice-actions align-right" style="margin-top: 20px">
                        <button id="print">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="jquery.js"></script>
    <script src="script.js"></script>
</body>
<?php include 'footer.php'; ?>

</html>
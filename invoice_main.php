<?php
session_start();
include 'nav.php';
include 'invoice_class.php';
require 'config.php';
include 'format_invoice_no.php';

$host = 'localhosT';
$dbname = 'pos';
$username = 'root';
$password = '';
$current_date = date('Y-m-d H:i:s');
$iinvoice_no = 0;
$retno = 0;
$class = '';
$retclass = '';
$addclass = 'hide';
$results = [];
$i = 0;

if (isset($_GET['iinvoice_no']) && !empty($_SERVER['QUERY_STRING'])) {
    $iinvoice_no = $_GET['iinvoice_no'];
    if ($iinvoice_no > 0) { // edit mode
        $class = 'hide';
        $addclass = '';
        $retclass = 'hide';

        //get invoice header and details in single query
        $sql = "SELECT * FROM invoice_header WHERE iinvoice_no = $iinvoice_no;";
        $sql .= "SELECT * FROM invoice_detail WHERE iinvoice_no = $iinvoice_no;";

        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    $results[$i] = [];
                    while ($row = $result->fetch_assoc()) {
                        $results[$i][] = $row;
                    }
                    $result->free_result();
                    $i++;
                }
            } while ($conn->more_results() && $conn->next_result());
        }
    }
} else if (isset($_GET['ret'])) {
    $iinvoice_no = $_GET['ret'];
    $retno =  $_GET['ret'];
    if ($iinvoice_no > 0) { // edit mode
        $class = '';
        $addclass = 'hide';
        $retclass = 'hide';
        //get invoice header and details in single query
        $sql = "SELECT * FROM invoice WHERE iinvoice_no = $iinvoice_no;";
        $sql .= "SELECT * FROM invoice_de WHERE iinvoice_no = $iinvoice_no;";

        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    $results[$i] = [];
                    while ($row = $result->fetch_assoc()) {
                        $results[$i][] = $row;
                    }
                    $result->free_result();
                    $i++;
                }
            } while ($conn->more_results() && $conn->next_result());
        }
    }
}
// $conn->close();
// Separate the results into users and orders
$invoiceHeader = InvoiceHeader::fromArray(isset($results[0]) ? $results[0][0] : []);
$invoiceDetails = [];
$i = 0;
if ($results && $results[1]) {
    foreach ($results[1] as $detail) {
        $invoiceDetails[$i] = InvoiceDetail::fromArray($detail);
        $i++;
    }
}
?>
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
    <!-- <?php echo $invoiceHeader->iinvoice_no; ?><br>
    <?php foreach ($invoiceDetails as $detail) {
        echo $detail->product_name . '<br>';
    } ?> -->
    <div class="row">
        <div class="col-md-8 left-section pt20 pr40 pb20 pl40" style="border-right: solid 1px #adadad;">
            <div class="invoice-header">
                <div style="display: flex; justify-content: space-between;">
                    <h3 style="margin-bottom: 50px">INVOICE NEW</h3>
                    <div>
                        <div class="align-right <?php echo $addclass; ?>">
                            <strong>Counter:</strong>&nbsp;<?php echo $invoiceHeader->icounter; ?>
                        </div>
                        <div class="align-right <?php echo $class; ?>">
                            <strong>Counter:</strong>&nbsp;<?php echo $_SESSION['counter_number']; ?>
                        </div>
                        <div class="align-right <?php echo $addclass; ?>"><?php echo $invoiceHeader->create_date; ?>
                        </div>
                        <div class="align-right <?php echo $class; ?>"><?php echo $current_date; ?></div>
                    </div>
                </div>
            </div>
            <div class="invoice-details">
                <input type="hidden" id="stand" class="stand" name="stand[]" value="<?= $retno; ?>">
                <!-- <h5>ITEMS</h5> -->
                <table id="invoice_table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total Price</th>
                            <th class="align-center <?php echo $class; ?>">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($results && $results[1]) {
                            foreach ($invoiceDetails as $key => $detail) {
                                ?>
                                <tr>
                                    <td style="text-align: center">
                                        <?php echo $key + 1; ?>
                                    </td>
                                    
                                    <td class="product_autocomplete">
                                        <input type="text" class="product_name" name="product_name[]" autocomplete="off"
                                            data-iproduct_identity="<?php echo $detail->iproduct_identity; ?>"
                                            onkeyup="setupAutocomplete(this)" onblur="setProductOnBlur(this)" value="<?php echo $detail->product_name; ?>">
                                        <ul class="product_autocomplete_list"></ul>
                                    </td>
                                    <td><input type="number" class="qty" onkeyup="calculateProductTotal(this)" name="qty[]"
                                            min="1" value="<?php echo $detail->quantity; ?>"></td>
                                    <td><input type="number" class="price" onkeyup="calculateProductTotal(this)" name="price[]"
                                            value="<?php echo $detail->price; ?>">
                                    </td>
                                    <td><input type="number" class="totalprice" name="totalprice[]" readonly
                                            value="<?php echo $detail->amount; ?>"></td>
                                    <td class="align-center <?php echo $class; ?>">
                                        <button class="delete btn btn-danger btn-sm"><i
                                                class="fa-solid fa-trash-can"></i></button>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else { 
                            for ($i = 1; $i < 6; ++$i) { ?>     
                            <tr>
                                <td style="text-align: center">
                                    <?=$i?>
                                </td>
                                
                                <td class="product_autocomplete">
                                    <input type="text" class="product_name" name="product_name[]" autocomplete="off"
                                        onkeyup="setupAutocomplete(this)"  onblur="setProductOnBlur(this)">
                                    <ul class="product_autocomplete_list"></ul>
                                </td>
                                <td><input type="number" class="qty" onkeyup="calculateProductTotal(this)" name="qty[]"
                                        min="1" value="1"></td>
                                <td><input type="number" class="price" onkeyup="calculateProductTotal(this)" name="price[]">
                                </td>
                                <td><input type="number" class="totalprice" name="totalprice[]" readonly></td>
                                <td class="align-center <?php echo $class; ?>">
                                    <button class="delete btn btn-danger btn-sm"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        <?php }} ?>

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-6" style="display: flex; flex-direction: column;">
                    <div class="invoice-actions <?php echo $class; ?>">
                        <button id="add_row" style="width: 100%; margin: 10px 0px;">Add New Row</button>
                    </div>
                    <div class="invoice-actions"
                        style="display: flex;justify-content: flex-start;align-items: flex-end;flex-grow: 1;margin-bottom: 20px;">
                        <button id="back">Back</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row margin-bottom-5">
                        <div class="col-md-6 align-right">Subtotal:</div>
                        <div class="col-md-6"><input type="text" id="subtotal" name="subtotal" readonly
                                value="<?php echo $invoiceHeader->subtotal; ?>"></div>
                    </div>
                    <div class="row margin-bottom-5">
                        <div class="col-md-6 align-right">Tax (GST):</div>
                        <div class="col-md-6"><input type="text" id="tax" name="tax" readonly
                                value="<?php echo $invoiceHeader->tax; ?>"></div>
                    </div>
                    <div class="row margin-bottom-5">
                        <div class="col-md-6 align-right">Total:</div>
                        <div class="col-md-6"><input type="text" id="total" name="total" readonly
                                value="<?php echo $invoiceHeader->total; ?>"></div>
                    </div>
                    <div class="row margin-bottom-5">
                        <div class="col-md-6 align-right">Payment Method:</div>
                        <div class="col-md-6">
                            <select name="payment_method" id="payment_method">
                                <option <?php echo $invoiceHeader->payment_method == 'Cash' ? 'selected' : ''; ?>>Cash
                                </option>
                                <option <?php echo $invoiceHeader->payment_method == 'Credit_card' ? 'selected' : ''; ?>>
                                    Credit_card</option>
                                <option <?php echo $invoiceHeader->payment_method == 'Debit_card' ? 'selected' : ''; ?>>
                                    Debit_card</option>
                            </select>
                        </div>
                    </div>
                    <div class="invoice-actions align-right" style="margin-top: 20px;">
                        <button id="save" class="<?php echo $class; ?>">Save</button>
                        <button id="savenprint" class="<?php echo $class; ?>">Save & Print</button>
                        <button id="hold" class="<?php echo $retclass; ?>">Hold</button>
                        <button id="print" class="<?php echo $addclass; ?>">Print</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2  pt20 pr20 pb20 pl20" style="border-right: solid 1px #adadad;">
            STAND BY INVOICES
            <?php
            $sql = "SELECT * FROM invoice";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <a style="text-decoration: none" href="invoice_main.php?ret=<?= $row['iinvoice_no']; ?>">
                        <div class="invoice-card <?= $retno == $row['iinvoice_no'] ? 'active' : ''; ?>">
                            <div class="invoice-card-title">
                                <strong><?= getFormattedInvoiceNo($row['iinvoice_no']); ?></strong>
                                <div class="counter">Counter:<strong><?= $row['icounter']; ?></strong></div>
                            </div>
                            <div class="invoice-card-content">
                                Total: <strong><?= $row['total']; ?></strong>
                            </div>
                        </div>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-md-2 pt20 pr20 pb20 pl20">
            RECENT INVOICES
            <div class="right-section">
                <?php
            $sql = "SELECT * FROM invoice_header WHERE create_date >= NOW() - INTERVAL 1 DAY";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <a style="text-decoration: none" href="invoice_main.php?iinvoice_no=<?= $row['iinvoice_no']; ?>">
                        <div class="invoice-card <?= $iinvoice_no == $row['iinvoice_no'] ? 'active' : ''; ?>">
                            <div class="invoice-card-title">
                                <strong><?= getFormattedInvoiceNo($row['iinvoice_no']); ?></strong>
                                <div class="counter">Counter:<strong><?= $row['icounter']; ?></strong></div>
                            </div>
                            <div class="invoice-card-content">
                                Total: <strong><?= $row['total']; ?></strong>
                            </div>
                        </div>
                    </a>
                    <?php
                }
            } ?>
            </div>
        </div>
    </div>

    <script src="jquery.js"></script>
    <script src="script.js"></script>
</body>
<?php include 'footer.php'; ?>

</html>
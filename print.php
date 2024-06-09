<?php
include 'format_invoice_no.php';
// Database connection
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch store details
$storeQuery = "SELECT store_name, store_address, gst_no FROM store LIMIT 1";
$storeResult = $conn->query($storeQuery);
$store = $storeResult->fetch_assoc();

// Fetch invoice header details
//$iinvoice_no=$_GET['invoice_id'];
$headerQuery = "SELECT * FROM invoice_header WHERE iinvoice_no = '{$_GET['invoice_id']}'";
$headerResult = $conn->query($headerQuery);
$header = $headerResult->fetch_assoc();

// Fetch invoice detail
$detailQuery = "SELECT product_name, quantity, amount, price FROM invoice_detail WHERE iinvoice_no = '{$_GET['invoice_id']}'";
$detailResult = $conn->query($detailQuery);
$products = [];
while ($row = $detailResult->fetch_assoc()) {
    $products[] = $row;
}
// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=320, initial-scale=1.0, maximum-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <title>Invoice</title>
    <style>
        body {
            font-family: "Hanken Grotesk", sans-serif;
        }

        .invoice-box {
            max-width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 12px;
            line-height: 1.5em;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 0px solid #eee;
            font-weight: bold;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .invoice-box,
            .invoice-box * {
                visibility: visible;
            }

            .invoice-box {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                max-width: 300px;
            }

        }

        .terms {
            border-top: solid 1px #dfdfdf;
            padding-top: 10px;
            font-size: 9px;
            line-height: 10px;
            border-bottom: solid 1px #dfdfdf;
        }

        .terms p {
            text-align: justify;
        }

        .bar-code {
            font-family: 'Free 3 of 9';
            font-size: 20px;
            font-weight: 400;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="title" style="text-align:center;margin-bottom: 20px;">
            <h2 style="border-bottom: solid 1px #dfdfdf; padding-bottom: 20px;"><?= $store['store_name']?></h2>
            <div class="information" style="border-bottom: solid 1px #dfdfdf; padding-bottom: 20px;">
                <?php echo $store['store_address']; ?><br>
                <strong>CIN:</strong>L17110MH1973PLC019786<br>
                <strong>GST:</strong> <?php echo $store['gst_no']; ?>
            </div>
        </div>

        <table cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2">
                    <strong>Invoice #:</strong> <?php echo getFormattedInvoiceNo($header['iinvoice_no']); ?>
                </td>
                <div class="bar-code">*IINVOICE*</div>
                <td colspan="2">
                    <strong>Date:</strong> <?php echo $header['create_date']; ?><br>
                    <strong>Counter #:</strong> <?php echo $_SESSION['counter_number']; ?>
                </td>
            </tr>
            <tr>
                <td colspan="4" align="center" style="font-size: 11px;">
                    &nbsp;
                    <i>(Price of all products listed below may vary every day. The list is as per when the bill was
                        generated.)</i>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Product
                </td>
                <td>
                    Quantity
                </td>
                <td align="right">
                    Price
                </td>
                <td align="right">
                    Amount
                </td>
            </tr>

            <?php foreach ($products as $product) { ?>
                <tr class="item">
                    <td>
                        <?php echo $product['product_name']; ?>
                    </td>
                    <td>
                        <?php echo $product['quantity']; ?>
                    </td>
                    <td align="right">
                        <?php echo number_format($product['price'], 2); ?> ₹
                    </td>
                    <td align="right">
                        <?php echo number_format($product['amount'], 2); ?> ₹
                    </td>
                </tr>
            <?php } ?>

            <tr class="total">
                <td colspan="3" align="right"><strong>Subtotal:</strong></td>
                <td align="right"><?php echo number_format($header['subtotal'], 2); ?> ₹</td>
            </tr>
            <tr class="total">
                <td colspan="3" align="right"><strong>GST:</strong></td>
                <td align="right"><?php echo number_format($header['tax'], 2); ?> ₹</td>
            </tr>
            <tr class="total">
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td align="right"><?php echo number_format($header['total'], 2); ?> ₹</td>
            </tr>
            <tr class="total">
                <td colspan="3" align="right"><strong>Payment Method:</strong></td>
                <td align="right"><?php echo $header['payment_method']; ?></td>
            </tr>

            <tr>
                <td colspan="4" align="center" class="terms">
                    <strong>Terms and Conditions</strong>
                    <p>
                        Goods once sold will not be taken back or exchanged unless
                        there is a manufacturing defect or quality issue, in which case
                        the item must be returned within 7 days of purchase with the original receipt.
                    </p>
                    <p>
                        Warranty and service for electronic goods and appliances will be provided
                        by the respective manufacturers as per their terms. Please contact the
                        manufacturer directly for any warranty-related issues.
                    </p>
                    <p>
                        All prices are inclusive of applicable taxes. If there is any discrepancy in
                        the amount charged, please contact the customer service desk within 48 hours with the original
                        receipt.
                    </p>
                    <p>
                        Payment should be made in full at the time of purchase.
                        We accept cash, credit/debit cards, and digital payments. Cheques are not accepted.
                    </p>
                    <p>
                        In case of credit/debit card payments, the cardholder must be present with valid ID proof. We do
                        not accept third-party cards.
                    </p>
                    <p>
                        Offers and discounts are subject to change without prior notice. Discounts cannot be combined
                        with other offers unless explicitly stated.
                    </p>
                    <p>
                        Perishable goods such as food items, dairy products, and bakery items are not returnable.
                    </p>
                    <p>
                        Customer information provided during purchase may be used for billing and
                        promotional purposes as per our privacy policy. We do not share customer information with third
                        parties without consent.
                    </p>
                    <p>
                        Store timings: The store operates from [insert store timing] on all days except national
                        holidays.
                    </p>
                    <p>
                        In case of disputes, the decision of the store management will be final and binding.
                        Legal jurisdiction will be [insert appropriate jurisdiction].
                    </p>
                    <p>
                        Contact Us: For any queries or concerns, please contact our customer service at
                        +91-900000000 or email us at pjay0566@gmail.com.
                    </p>
                </td>
            </tr>
        </table>
    </div>
    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>

</html>
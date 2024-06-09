<?php
function getFormattedInvoiceNo($i)
{
    $prefix = "INV";
    $prefix_number = "";
    $min_length = 5;
    for ($x = 0; $x < $min_length - strlen($i); $x++) {
        $prefix_number = $prefix_number . "0";
    }
    return $prefix . $prefix_number . $i;
}
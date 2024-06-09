<?php
class InvoiceDetail {
    public $iinvoice_no;
    public $iproduct_identity;
	public $product_name;
	public $price;
	public $amount;
	public $quantity;
    
    public static function fromArray($array) {
        $o = new self();
        foreach ($array as $key => $value) {
            if (property_exists($o, $key)) {
                $o->$key = $value;
            }
        }
        return $o;
    }
}

class InvoiceHeader {
    public $iinvoice_no;
    public $icounter;
    public $create_date;
	public $subtotal;
	public $tax;
	public $total;
	public $payment_method;
	public static function fromArray($array) {
        $o = new self();
        foreach ($array as $key => $value) {
            if (property_exists($o, $key)) {
                $o->$key = $value;
            }
        }
        return $o;
    }
}

?>
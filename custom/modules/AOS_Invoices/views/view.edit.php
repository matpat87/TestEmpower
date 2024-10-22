<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/modules/AOS_Invoices/helpers/InvoiceHelper.php');

class AOS_InvoicesViewEdit extends ViewEdit {
    function __construct(){
        parent::__construct();
    }

    function display() {
        $this->setDefaults();
        parent::display();
    }

    function setDefaults(){
        if(!InvoiceHelper::is_id_exists($this->bean->id)){
            $this->bean->total_amt = '0.00';
            $this->bean->total_discount_c = '0.00';
            $this->bean->subtotal_amount = '0.00';
            $this->bean->misc_amount_c = '0.00';
            $this->bean->shipping_amount = '0.00';
            $this->bean->tax_amount = '0.00';
            $this->bean->total_amount = '0.00';
        }
        
    }
}

?>

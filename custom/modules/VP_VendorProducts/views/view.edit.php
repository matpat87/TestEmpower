<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');



class VP_VendorProductsViewEdit extends ViewEdit {
    function __construct(){
        parent::__construct();
    }

    function display() {
        global $app_list_strings;

        if(strpos($this->bean->product_price_c, '$') === false)
		{
			$bean_amount = "$" . number_format($this->bean->product_price_c, 2, '.', ',');
			$this->bean->product_price_c = $bean_amount;
		}


        $this->bean->product_price_c = NumberHelper::GetCurrencyValue($this->bean->product_price_c);
        $this->bean->last_purchase_price = NumberHelper::GetCurrencyValue($this->bean->last_purchase_price);

        if (! $this->ev->focus->id) {
            echo "<script type=\"text/javascript\">
               $(document).ready(function(e){
                   $('input#name')
                    .removeClass('custom-readonly')
                    .removeAttr('readonly');
                   
               });
               </script>";
			
		}
        parent::display();
    }
}
?>

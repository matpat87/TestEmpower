<?php

require_once('include/MVC/View/views/view.detail.php');

class CasesViewDetail extends ViewDetail {

	function __construct(){
        parent::__construct();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function CasesViewDetail(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


	function display(){
		parent::display();

        // Hide input fields so that custom non-db fields will display labels only
        // Added by: Ralph Julian Siasat
        echo 
        "<script>
            $(document).ready(function(){
                var panel_bg_color = $('li.active > a').first().css('background-color');
    
                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db']\").prev().removeClass('col-sm-2').addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12').css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px');

                $(\"div[field='product_header_non_db'],div[field='product_customer_process_non_db'],div[field='product_disposition_non_db']\").addClass('hidden');
            });
        </script>";
	}
}

<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once ("include/MVC/View/views/view.popup.php");

class AOS_InvoicesViewPopup extends ViewPopup
{

    public function display()
    {
        global $log;
        if ($_REQUEST['action'] == 'Popup' && $_REQUEST['module'] = 'AOS_Invoices' && (isset($_REQUEST['customer_product_id']) || isset($_REQUEST['account_id']))) {

            $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $_REQUEST['customer_product_id']);
            $accountsBean = BeanFactory::getBean('Accounts', $_REQUEST['account_id']);

            
            $_REQUEST['account_name_nondb_advanced'] = ($accountsBean) 
                ? $accountsBean->name 
                : "";
            $_REQUEST['customer_product_number_nondb_advanced'] = ($customerProductBean)
                ? $customerProductBean->product_number_c
                : "";
            
           
        }

        parent::display();
    }


}
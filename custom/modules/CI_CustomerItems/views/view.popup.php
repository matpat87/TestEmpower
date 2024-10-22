<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once ("include/MVC/View/views/view.popup.php");

class CI_CustomerItemsViewPopup extends ViewPopup
{

    public function display()
    {
        global $log;


        if ($_REQUEST['action'] == 'Popup' 
            && $_REQUEST['module'] = 'CI_CustomerItems' 
            && $_REQUEST['account_id'] == true) {

            $accountsBean = BeanFactory::getBean('Accounts', $_REQUEST['account_id']);
            
            $_REQUEST['account_name_nondb_advanced'] = ($accountsBean) 
                ? $accountsBean->name 
                : "";
            
        }

        parent::display();
    }   


}
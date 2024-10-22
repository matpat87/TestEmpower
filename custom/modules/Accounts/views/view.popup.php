<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once ("include/MVC/View/views/view.popup.php");

class AccountsViewPopup extends ViewPopup
{

    public function display()
    {
        global $log;
        
        if ($_REQUEST['action'] == 'Popup' && $_REQUEST['module'] = 'Accounts') {
            if (isset($_REQUEST['account_type_param']) && !empty($_REQUEST['account_type_param'])) {
                $_SESSION['popup_account_type'] = $_REQUEST['account_type_param'];
            }
        }
        
        parent::display();
    }
}
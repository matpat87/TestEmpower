<?php

require_once('include/MVC/View/views/view.list.php');
require_once('modules/Accounts/AccountsListViewSmarty.php');

class AccountsViewList extends ViewList
{
    /**
     * @see ViewList::preDisplay()
     */

    public function preDisplay(){
    	global $current_user;

        require_once('modules/AOS_PDF_Templates/formLetter.php');
        formLetter::LVPopupHtml('Accounts');
        parent::preDisplay();

        if(!$current_user->isAdmin() && !isset($_REQUEST['assigned_user_id_advanced'])) {
        	$_REQUEST['searchFormTab'] = "advanced_search";
    		$_REQUEST['query'] = "true";
        	$_REQUEST['assigned_user_id_advanced'][0] = $current_user->id;
        }
        
        $this->lv = new AccountsListViewSmarty();
    }

}

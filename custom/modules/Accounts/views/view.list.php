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

        // Clear filters if accessed via Menu or "View Accounts"
        if( (isset($_REQUEST['parentTab']) && !empty($_REQUEST['parentTab'])) || ((isset($_REQUEST['return_module']) && !empty($_REQUEST['return_module'])) && (isset($_REQUEST['return_action']) && !empty($_REQUEST['return_action']))) ) {

	        $_REQUEST = [
	        	'action' => 'index',
			    'module' => 'Accounts',
			    'searchFormTab' => 'advanced_search',
			    'query' => 'true',
			    'clear_query' => 'true',
                'orderBy' => 'NAME',
                'sortOrder' => 'ASC'
	        ];
        }

        // Set default filter to logged user (if not admin) when accessing accounts list view
        if(!$current_user->isAdmin() && !isset($_REQUEST['assigned_user_id_advanced'])) {
        	$_REQUEST['assigned_user_id_advanced'][0] = $current_user->id;
        }

        parent::preDisplay();
        $this->lv = new AccountsListViewSmarty();
    }

}

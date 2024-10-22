<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/




require_once('include/Dashlets/Dashlet.php');

class MyTopTenAccountsDashlet extends Dashlet 
{ 
    protected $myTopTenAccounts;
	
	/**
	 * @see Dashlet::Dashlet()
	 */
	public function __construct($id, $def = null) 
	{
        global $current_user, $app_strings, $db;
        parent::__construct($id);
        $this->isConfigurable = true;
        $this->isRefreshable = true;        
        $this->myTopTenAccounts = array();
        $this->seedBean = new Account();  
        if(empty($def['title'])) { 
            $this->title = translate('LBL_MY_TOP_TEN_ACCOUNTS_TITLE', 'Accounts'); 
        } else {
            $this->title = $def['title'];
        }
        
        if(isset($def['autoRefresh'])) $this->autoRefresh = $def['autoRefresh'];

        $query = "SELECT * FROM accounts
                  LEFT JOIN accounts_cstm
                    ON accounts.id = accounts_cstm.id_c
                  WHERE accounts.deleted = 0
                  AND accounts_cstm.sls_ytd_c IS NOT NULL ";
        $query .= "AND accounts.assigned_user_id =  '".$current_user->id."' ";
        $query .= "ORDER BY accounts_cstm.sls_ytd_c DESC LIMIT 10";
        $result = $db->query($query);

        $ctr = 0;

        while($row = $db->fetchByAssoc($result)) {
            $last_update = $row['last_activity_date_c'] ? new DateTime($row['last_activity_date_c']) : false;
            
            $this->myTopTenAccounts[$ctr]['id'] = $row['id'];
            $this->myTopTenAccounts[$ctr]['name'] = $row['name'];
            $this->myTopTenAccounts[$ctr]['last_activity_date_c'] = $last_update ? $last_update->format('Y-m-d') : '';
            $this->myTopTenAccounts[$ctr]['phone_office'] = $row['phone_office'];            
            $this->myTopTenAccounts[$ctr]['shipping_address_city'] = $row['shipping_address_city'];
            $this->myTopTenAccounts[$ctr]['shipping_address_state'] = $row['shipping_address_state'];
            $this->myTopTenAccounts[$ctr]['sls_ytd_c'] = '$' . number_format($row['sls_ytd_c']);
            $this->myTopTenAccounts[$ctr]['sls_lytd_c'] = '$' . number_format($row['sls_lytd_c']);
            $ctr++;
        }
    }
    
    /**
	 * @see Dashlet::display()
	 */
	public function display()
    {	
    	$ss = new Sugar_Smarty();
    	$ss->assign('lblAccountName', str_replace(':', '', translate('LBL_ACCOUNT_NAME', 'Accounts')));
        $ss->assign('lblLastActivityDate', str_replace(':', '', translate('LBL_MY_TOP_TEN_LAST_UPDATE', 'Accounts')));    
        $ss->assign('lblPhone', str_replace(':', '', translate('LBL_PHONE', 'Accounts')));    
        $ss->assign('lblShippingCity', str_replace(':', '', translate('LBL_SHIPPING_ADDRESS_CITY', 'Accounts')));    
        $ss->assign('lblShippingState', str_replace(':', '', translate('LBL_MY_TOP_TEN_ACCOUNTS_STATE', 'Accounts')));    
    	$ss->assign('lblShippingYTDSales', str_replace(':', '', translate('LBL_SLS_YTD', 'Accounts')));   	
    	$ss->assign('lblShippingLYTDSales', str_replace(':', '', translate('LBL_SLS_LYTD', 'Accounts')));   	
    	   	
    	
        $ss->assign('myTopTenAccounts', $this->myTopTenAccounts);
    	
    	return parent::display() . $ss->fetch('modules/Accounts/Dashlets/MyTopTenAccountsDashlet/MyTopTenAccountsDashlet.tpl');
    }
    
    /**
	 * @see Dashlet::displayOptions()
	 */
	public function displayOptions() 
    {
        $ss = new Sugar_Smarty();
        $ss->assign('titleLBL', translate('LBL_DASHLET_OPT_TITLE', 'Home'));
        $ss->assign('title', $this->title);
        $ss->assign('id', $this->id);
        $ss->assign('saveLBL', $GLOBALS['app_strings']['LBL_SAVE_BUTTON_LABEL']);
        if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
        
		return $ss->fetch('modules/Accounts/Dashlets/MyTopTenAccountsDashlet/MyTopTenAccountsDashletConfigure.tpl');        
    }

    /**
	 * @see Dashlet::saveOptions()
	 */
	public function saveOptions($req) 
    {
        $options = array();
        
        if ( isset($req['title']) ) {
            $options['title'] = $req['title'];
        }
        $options['autoRefresh'] = empty($req['autoRefresh']) ? '0' : $req['autoRefresh'];
        
        return $options;
    }   
}

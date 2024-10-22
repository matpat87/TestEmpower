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


class MySalesPerformanceDashlet extends Dashlet {

    var $my_sales_performance_group_user_id;

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    function __construct($id, $def) {

        global $current_user, $app_strings, $db;
        $this->loadLanguage('MySalesPerformanceDashlet'); // load the language strings here

        parent::__construct($id); // call parent constructor
        
        $this->isConfigurable = false; // dashlet is configurable
        $this->isRefreshable = true;
        $this->mySalesPerformance = array();
        $this->seedBean = new Account();

        // if no custom title, use default
        if(empty($def['title'])) $this->title = $this->dashletStrings['LBL_TITLE'];
        else $this->title = $def['title'];

        if(isset($def['autoRefresh'])) $this->autoRefresh = $def['autoRefresh'];

        $this->my_sales_performance_group_user_id = empty($def['my_sales_performance_group_user_id']) ? $current_user->id : $def['my_sales_performance_group_user_id'];

        $query = "SELECT * FROM sales_performance
                  LEFT JOIN users
                    ON users.user_name = sales_performance.salesperson
                  WHERE users.id = '". $this->my_sales_performance_group_user_id ."'";
        $result = $db->query($query);
        $row = $db->fetchByAssoc($result);
        
        /* 
            - If the salesperson is above budget then = Green
            - If the salesperson is below budget but above last year = Yellow
            - If the salesperson is below budget and below last year + Red
        */

        if (! $row['cmy_budget_sales'] && ! $row['cmy_actual_sales'] && ! $row['lmy_actual_sales']) {
            $this->mySalesPerformance['sales_dot_color'] = 'dot-gray';
        } else {
            if (! $row['cmy_budget_sales'] || $row['cmy_budget_sales'] <= 0) {
                $this->mySalesPerformance['sales_dot_color'] = 'dot-red';
    
                if ($row['cmy_actual_sales'] >= $row['lmy_actual_sales']) {
                    $this->mySalesPerformance['sales_dot_color'] = 'dot-green';
                }
            } else {
                if ($row['cmy_budget_sales'] > $row['cmy_actual_sales']) {
                    $this->mySalesPerformance['sales_dot_color'] = 'dot-red';
    
                    if ($row['cmy_actual_sales'] >= $row['lmy_actual_sales']) {
                        $this->mySalesPerformance['sales_dot_color'] = 'dot-amber';
                    }
                } else {
                    $this->mySalesPerformance['sales_dot_color'] = 'dot-red';
    
                    if ($row['cmy_actual_sales'] >= $row['lmy_actual_sales']) {
                        $this->mySalesPerformance['sales_dot_color'] = 'dot-green';
                    } else {
                        $this->mySalesPerformance['sales_dot_color'] = 'dot-amber';
                    }
                }
            }
        }

        if (! $row['cmy_budget_margin'] && ! $row['cmy_actual_margin'] && ! $row['lmy_actual_margin']) {
            $this->mySalesPerformance['margin_dot_color'] = 'dot-gray';
        } else {
            if (! $row['cmy_budget_margin'] || $row['cmy_budget_margin'] <= 0) {
                $this->mySalesPerformance['margin_dot_color'] = 'dot-red';
    
                if ($row['cmy_actual_margin'] >= $row['lmy_actual_margin']) {
                    $this->mySalesPerformance['margin_dot_color'] = 'dot-green';
                }
            } else {
                if ($row['cmy_budget_margin'] > $row['cmy_actual_margin']) {
                    $this->mySalesPerformance['margin_dot_color'] = 'dot-red';
    
                    if ($row['cmy_actual_margin'] >= $row['lmy_actual_margin']) {
                        $this->mySalesPerformance['margin_dot_color'] = 'dot-amber';
                    }
                } else {
                    $this->mySalesPerformance['margin_dot_color'] = 'dot-red';
    
                    if ($row['cmy_actual_margin'] >= $row['lmy_actual_margin']) {
                        $this->mySalesPerformance['margin_dot_color'] = 'dot-green';
                    } else {
                        $this->mySalesPerformance['margin_dot_color'] = 'dot-amber';
                    }
                }
            }
        }

        if (! $row['cmy_budget_volume'] && ! $row['cmy_actual_volume'] && ! $row['lmy_actual_volume']) {
            $this->mySalesPerformance['volume_dot_color'] = 'dot-gray';
        } else {
            if (! $row['cmy_budget_volume'] || $row['cmy_budget_volume'] <= 0) {
                $this->mySalesPerformance['volume_dot_color'] = 'dot-red';
    
                if ($row['cmy_actual_volume'] >= $row['lmy_actual_volume']) {
                    $this->mySalesPerformance['volume_dot_color'] = 'dot-green';
                }
            } else {
                if ($row['cmy_budget_volume'] > $row['cmy_actual_volume']) {
                    $this->mySalesPerformance['volume_dot_color'] = 'dot-red';
    
                    if ($row['cmy_actual_volume'] >= $row['lmy_actual_volume']) {
                        $this->mySalesPerformance['volume_dot_color'] = 'dot-amber';
                    }
                } else {
                    $this->mySalesPerformance['volume_dot_color'] = 'dot-red';
    
                    if ($row['cmy_actual_volume'] >= $row['lmy_actual_volume']) {
                        $this->mySalesPerformance['volume_dot_color'] = 'dot-green';
                    } else {
                        $this->mySalesPerformance['volume_dot_color'] = 'dot-amber';
                    }
                }
            }
        }
        
      

        $this->mySalesPerformance['lmy_actual_sales'] = "$" . number_format($row['lmy_actual_sales'] ?? 0);
        $this->mySalesPerformance['cmy_actual_sales'] = "$" . number_format($row['cmy_actual_sales'] ?? 0);
        $this->mySalesPerformance['cmy_budget_sales'] = "$" . number_format($row['cmy_budget_sales'] ?? 0);
        $this->mySalesPerformance['lmy_actual_volume'] = number_format($row['lmy_actual_volume'] ?? 0);
        $this->mySalesPerformance['cmy_actual_volume'] = number_format($row['cmy_actual_volume'] ?? 0);
        $this->mySalesPerformance['cmy_budget_volume'] = number_format($row['cmy_budget_volume'] ?? 0);
        $this->mySalesPerformance['lmy_actual_margin'] = $row['lmy_actual_margin'] ?? 0;
        $this->mySalesPerformance['cmy_actual_margin'] = $row['cmy_actual_margin'] ?? 0;
        $this->mySalesPerformance['cmy_budget_margin'] = $row['cmy_budget_margin'] ?? 0;
        
        
        $this->mySalesPerformance['lmy_actual_asp'] = ($row['lmy_actual_volume'] > 0) 
            ? number_format($row['lmy_actual_sales'] / $row['lmy_actual_volume'], 2) 
            : number_format(0, 2);
       
        $this->mySalesPerformance['cmy_actual_asp'] = ($row['cmy_actual_volume'] > 0) 
            ? number_format($row['cmy_actual_sales'] / $row['cmy_actual_volume'], 2) 
            : number_format(0, 2);
        $this->mySalesPerformance['cmy_budget_asp'] = ($row['cmy_budget_volume'] > 0) 
            ? number_format($row['cmy_budget_sales'] / $row['cmy_budget_volume'], 2)  
            : number_format(0, 2);
        
        // FOR ASP ROW DOT COLORS
        if ($this->mySalesPerformance['lmy_actual_asp']  == 0
                && $this->mySalesPerformance['cmy_actual_asp'] == 0
                &&  $this->mySalesPerformance['cmy_budget_asp'] == 0) {

            $this->mySalesPerformance['asp_dot_color'] = 'dot-gray';
        } else {
            
            if (! $this->mySalesPerformance['cmy_budget_asp'] || $this->mySalesPerformance['cmy_budget_asp'] <= 0) {
                $this->mySalesPerformance['asp_dot_color'] = 'dot-red';
    
                if ($this->mySalesPerformance['cmy_actual_asp'] >= $this->mySalesPerformance['lmy_actual_asp']) {
                    $this->mySalesPerformance['asp_dot_color'] = 'dot-green';
                }
            } else {
                if ($this->mySalesPerformance['cmy_budget_asp'] > $this->mySalesPerformance['cmy_actual_asp']) {
                    $this->mySalesPerformance['asp_dot_color'] = 'dot-red';
    
                    if ($this->mySalesPerformance['cmy_actual_asp'] >= $row['lmy_actual_volume']) {
                        $this->mySalesPerformance['asp_dot_color'] = 'dot-amber';
                    }
                } else {
                    $this->mySalesPerformance['asp_dot_color'] = 'dot-red';
    
                    if ( $this->mySalesPerformance['cmy_actual_asp'] >= $this->mySalesPerformance['lmy_actual_asp']) {
                        $this->mySalesPerformance['asp_dot_color'] = 'dot-green';
                    } else {
                        $this->mySalesPerformance['asp_dot_color'] = 'dot-amber';
                    }
                }
            }
        }

        
      
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function MySalesPerformanceDashlet($id, $def){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct($id, $def);
    }


    /**
	 * @see Dashlet::display()
	 */
	public function display()
    {	
        $salesGroupUsers = retrieveSalesGroupUsers();
        $salesGroupUserName = $salesGroupUsers[$this->my_sales_performance_group_user_id];
        
        $ss = new Sugar_Smarty();    	
        $ss->assign('mySalesPerformance', $this->mySalesPerformance);
        $ss->assign('my_sales_performance_group_user_id', $this->my_sales_performance_group_user_id);
        $ss->assign('current_salesgroup_name', $salesGroupUserName);
    	return parent::display() . $ss->fetch('modules/Home/Dashlets/MySalesPerformanceDashlet/MySalesPerformanceDashlet.tpl');
    }

    /**
	 * @see Dashlet::displayOptions()
	 */
	public function displayOptions() 
    {
        $salesGroupUsers = retrieveSalesGroupUsers();
        // $salesGroupUserName = $salesGroupUsers[$this->my_usage_sales_group_user_id];

        $ss = new Sugar_Smarty();
        $ss->assign('titleLBL', translate('LBL_DASHLET_OPT_TITLE', 'Home'));
        $ss->assign('title', $this->title);
        $ss->assign('id', $this->id);
        $ss->assign('usersFilter', 'User Filter');
        $ss->assign('my_sales_performance_group_user_id', $this->my_sales_performance_group_user_id);
        $ss->assign('saveLBL', $GLOBALS['app_strings']['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('salesGroupUsers', $salesGroupUsers);

        if($this->isAutoRefreshable()) {
       		$ss->assign('isRefreshable', true);
			$ss->assign('autoRefresh', $GLOBALS['app_strings']['LBL_DASHLET_CONFIGURE_AUTOREFRESH']);
			$ss->assign('autoRefreshOptions', $this->getAutoRefreshOptions());
			$ss->assign('autoRefreshSelect', $this->autoRefresh);
		}
        
		return $ss->fetch('modules/Home/Dashlets/MySalesPerformanceDashlet/MySalesPerformanceDashletConfigure.tpl');        
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
        $options['my_sales_performance_group_user_id'] = $req['my_sales_performance_group_user_id'];
        
        return $options;
    }   
}


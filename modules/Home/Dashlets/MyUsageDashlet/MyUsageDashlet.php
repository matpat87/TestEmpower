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


class MyUsageDashlet extends Dashlet {
    var $savedText; // users's saved text
    var $height = '200'; // height of the pad
    var $my_usage_sales_group_user_id;

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    function __construct($id, $def) {

        global $current_user;
        
        $this->loadLanguage('MyUsageDashlet'); // load the language strings here

        if(!empty($def['savedText']))  // load default text is none is defined
            $this->savedText = $def['savedText'];
        else
            $this->savedText = $this->dashletStrings['LBL_MY_USAGE_DEFAULT_TEXT'];

        if(!empty($def['height'])) // set a default height if none is set
            $this->height = $def['height'];

        parent::__construct($id); // call parent constructor

        $this->isConfigurable = true; // dashlet is configurable
        $this->isRefreshable = false;
        
        $this->my_usage_sales_group_user_id = empty($def['my_usage_sales_group_user_id']) ? $current_user->id : $def['my_usage_sales_group_user_id'];

        // if no custom title, use default
        if(empty($def['title'])) $this->title = $this->dashletStrings['LBL_MY_USAGE_TITLE'];
        else $this->title = $def['title'];
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function MyUsageDashlet($id, $def){
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
     * Displays the dashlet
     *
     * @return string html to display dashlet
     */
    function display() {

        $salesGroupUsers = retrieveSalesGroupUsers();
        $salesGroupUserName = $salesGroupUsers[$this->my_usage_sales_group_user_id];

        $ss = new Sugar_Smarty();
        $ss->assign('savedText', SugarCleaner::cleanHtml($this->savedText));
        $ss->assign('saving', $this->dashletStrings['LBL_MY_USAGE_SAVING']);
        $ss->assign('saved', $this->dashletStrings['LBL_MY_USAGE_SAVED']);
        $ss->assign('id', $this->id);
        $ss->assign('height', $this->height);
        $ss->assign('my_usage_sales_group_user_id', $this->my_usage_sales_group_user_id);
        $ss->assign('my_usage_sales_group_user_name', $salesGroupUserName);
        
        $str = $ss->fetch('modules/Home/Dashlets/MyUsageDashlet/MyUsageDashlet.tpl');

        echo '
        <!-- Styles -->
        <style>
            #my-usage-chart-div {
                width: 100%;
                height: 600px;
            }
        </style>
        
        <!-- Chart Code -->
        <script src="./modules/Home/Dashlets/MyUsageDashlet/js/amchart.js"></script>';
        return parent::display() . $str . '<br />'; // return parent::display for title and such
    }

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    function displayOptions() {
        global $app_strings;

        $salesGroupUsers = retrieveSalesGroupUsers();
        
        $ss = new Sugar_Smarty();
        $ss->assign('titleLbl', $this->dashletStrings['LBL_MY_USAGE_CONFIGURE_TITLE']);
        $ss->assign('saveLbl', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('clearLbl', $app_strings['LBL_CLEAR_BUTTON_LABEL']);
        $ss->assign('title', $this->title);
        $ss->assign('salesGroupUsers', $salesGroupUsers);
        $ss->assign('id', $this->id);
        $ss->assign('my_usage_sales_group_user_id', $this->my_usage_sales_group_user_id);
        
        return parent::displayOptions() . $ss->fetch('modules/Home/Dashlets/MyUsageDashlet/MyUsageDashletOptions.tpl');
    }

    /**
     * called to filter out $_REQUEST object when the user submits the configure dropdown
     *
     * @param array $req $_REQUEST
     * @return array filtered options to save
     */
    function saveOptions($req) {
        $options = array();
        $options['title'] = $req['title'];
        $options['my_usage_sales_group_user_id'] = $req['my_usage_sales_group_user_id'];
        return $options;
    }
}


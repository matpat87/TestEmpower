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


class OpportunityByVolumeDashlet extends Dashlet {
    var $savedText; // users's saved text
    var $height = '200'; // height of the pad
    var $opportunity_by_volume_my_opportunities;
    var $opportunity_by_volume_sales_group_user_ids;
    var $opportunity_by_volume_sales_stages;
    var $opportunity_by_volume_amount;
    var $opportunity_by_volume_date_from;
    var $opportunity_by_volume_date_to;

    /**
     * Constructor
     *
     * @global string current language
     * @param guid $id id for the current dashlet (assigned from Home module)
     * @param array $def options saved for this dashlet
     */
    function __construct($id, $def) {

        global $current_user;
        
        $this->loadLanguage('OpportunityByVolumeDashlet', 'modules/Charts/Dashlets/'); // load the language strings here

        if(!empty($def['savedText']))  // load default text is none is defined
            $this->savedText = $def['savedText'];
        else
            $this->savedText = $this->dashletStrings['LBL_OPPORTUNITY_BY_VOLUME_DEFAULT_TEXT'];

        if(!empty($def['height'])) // set a default height if none is set
            $this->height = $def['height'];

        parent::__construct($id); // call parent constructor

        $this->isConfigurable = true; // dashlet is configurable
        $this->isRefreshable = false;
        $this->opportunity_by_volume_my_opportunities = empty($def['opportunity_by_volume_my_opportunities']) ? [] : $def['opportunity_by_volume_my_opportunities'];
        $this->opportunity_by_volume_sales_group_user_ids = empty($def['opportunity_by_volume_sales_group_user_ids']) ? [] : $def['opportunity_by_volume_sales_group_user_ids'];
        $this->opportunity_by_volume_sales_stages = empty($def['opportunity_by_volume_sales_stages']) ? [] : $def['opportunity_by_volume_sales_stages'];
        $this->opportunity_by_volume_amount = empty($def['opportunity_by_volume_amount']) ? '' : $def['opportunity_by_volume_amount'];
        $this->opportunity_by_volume_date_from = empty($def['opportunity_by_volume_date_from']) ? '' : $def['opportunity_by_volume_date_from'];
        $this->opportunity_by_volume_date_to = empty($def['opportunity_by_volume_date_to']) ? '' : $def['opportunity_by_volume_date_to'];
        
        // if no custom title, use default
        $this->title = (empty($def['title'])) ? $this->dashletStrings['LBL_OPPORTUNITY_BY_VOLUME_TITLE'] : $this->title = $def['title'];
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function OpportunityByVolumeDashlet($id, $def){
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

        $ss = new Sugar_Smarty();
        $ss->assign('savedText', SugarCleaner::cleanHtml($this->savedText));
        $ss->assign('saving', $this->dashletStrings['LBL_OPPORTUNITY_BY_VOLUME_SAVING']);
        $ss->assign('saved', $this->dashletStrings['LBL_OPPORTUNITY_BY_VOLUME_SAVED']);
        $ss->assign('id', $this->id);
        $ss->assign('height', $this->height);
        $ss->assign('opportunity_by_volume_my_opportunities', implode(',', $this->opportunity_by_volume_my_opportunities));
        $ss->assign('opportunity_by_volume_sales_group_user_ids', implode(',', $this->opportunity_by_volume_sales_group_user_ids));
        $ss->assign('opportunity_by_volume_sales_stages', implode(',', $this->opportunity_by_volume_sales_stages));
        $ss->assign('opportunity_by_volume_amount', $this->opportunity_by_volume_amount);
        $ss->assign('opportunity_by_volume_date_from', $this->opportunity_by_volume_date_from);
        $ss->assign('opportunity_by_volume_date_to', $this->opportunity_by_volume_date_to);

        $str = $ss->fetch('modules/Charts/Dashlets/OpportunityByVolumeDashlet/OpportunityByVolumeDashlet.tpl');

        echo '
        <!-- Styles -->
        <style>
            #opportunity-by-volume-chart-div {
                width: 100%;
                height: 600px;
            }
        </style>
        
        <!-- Chart Code -->
        <script src="./modules/Charts/Dashlets/OpportunityByVolumeDashlet/js/amchart.js"></script>';
        return parent::display() . $str . '<br />'; // return parent::display for title and such
    }

    /**
     * Displays the configuration form for the dashlet
     *
     * @return string html to display form
     */
    function displayOptions() {
        global $app_strings, $app_list_strings;

        $myOpportunities = $this->retrieveMyOpportunities();
        $salesGroupUsers = retrieveSalesGroupUsers();
        
        $ss = new Sugar_Smarty();
        $ss->assign('titleLbl', $this->dashletStrings['LBL_OPPORTUNITY_BY_VOLUME_CONFIGURE_TITLE']);
        $ss->assign('saveLbl', $app_strings['LBL_SAVE_BUTTON_LABEL']);
        $ss->assign('clearLbl', $app_strings['LBL_CLEAR_BUTTON_LABEL']);
        $ss->assign('title', $this->title);
        $ss->assign('myOpportunities', $myOpportunities);
        $ss->assign('salesGroupUsers', $salesGroupUsers);
        $ss->assign('salesStages', $app_list_strings['sales_stage_dom']);
        $ss->assign('id', $this->id);
        $ss->assign('opportunity_by_volume_my_opportunities', $this->opportunity_by_volume_my_opportunities);
        $ss->assign('opportunity_by_volume_sales_group_user_ids', $this->opportunity_by_volume_sales_group_user_ids);
        $ss->assign('opportunity_by_volume_sales_stages', $this->opportunity_by_volume_sales_stages);
        $ss->assign('opportunity_by_volume_amount', $this->opportunity_by_volume_amount);
        $ss->assign('opportunity_by_volume_date_from', $this->opportunity_by_volume_date_from);
        $ss->assign('opportunity_by_volume_date_to', $this->opportunity_by_volume_date_to);

        return parent::displayOptions() . $ss->fetch('modules/Charts/Dashlets/OpportunityByVolumeDashlet/OpportunityByVolumeDashletOptions.tpl');
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
        $options['opportunity_by_volume_my_opportunities'] = $req['opportunity_by_volume_my_opportunities'];
        $options['opportunity_by_volume_sales_group_user_ids'] = $req['opportunity_by_volume_sales_group_user_ids'];
        $options['opportunity_by_volume_sales_stages'] = $req['opportunity_by_volume_sales_stages'];
        $options['opportunity_by_volume_amount'] = $req['opportunity_by_volume_amount'];
        $options['opportunity_by_volume_date_from'] = $req['opportunity_by_volume_date_from'];
        $options['opportunity_by_volume_date_to'] = $req['opportunity_by_volume_date_to'];
        return $options;
    }

    function retrieveMyOpportunities()
    {
        global $db, $current_user;

        $sql = "SELECT * FROM opportunities
                WHERE deleted = 0";
        
        if (! $current_user->is_admin) {
            $sql .= " AND (
                (
                    opportunities.assigned_user_id = '{$current_user->id}'
                    OR EXISTS
                    ( 
                        SELECT 1 FROM securitygroups secg
                        INNER JOIN securitygroups_users secu 
                            ON secg.id = secu.securitygroup_id
                            AND secu.deleted = 0
                            AND secu.user_id = '{$current_user->id}'
                        INNER JOIN securitygroups_records secr 
                            ON secg.id = secr.securitygroup_id
                            AND secr.deleted = 0
                            AND secr.module = 'Opportunities'
                        WHERE secr.record_id = opportunities.id
                            AND secg.deleted = 0
                    )
                )
            ) ";
        }

        $sql .= " ORDER BY opportunities.name ASC "; 

        $result = $db->query($sql);
        
        $opportunities = array();

        while($row = $db->fetchByAssoc($result)){
            $opportunities[$row['id']] = $row['name'];
        }

        return $opportunities;
    }
}


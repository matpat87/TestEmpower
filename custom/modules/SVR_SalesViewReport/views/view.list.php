<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
 */

require_once('include/MVC/View/views/view.list.php');

class CustomSVR_SalesViewReportViewList extends ViewList
{

    function preDisplay() {
        parent::preDisplay();
        $this->renderSSRSReport();
    }

    public function renderSSRSReport() {
        global $current_user;

        $lowercasedUsername = strtolower($current_user->user_name);
        $credentials = array(
            'username' => 'empowerreports',
            'password' => '3Mp0w3r87750'
        );

        // URL Sample Output: http://corp01db.corp.local/Reports/report/Sales%20Reports/SalesView?ReportType=2&UserBased=Y&rc:Toolbar=false&Usr_Id=RSIASAT
        $ssrs = new \SSRS\Report('http://corp01db.corp.local/reportserver/', $credentials);
        $result = $ssrs->loadReport('/Sales Reports/SalesView');
    
        $reportParameters = array(
            'ReportType' => '2',
            'UserBased'  => 'Y',
            'Usr_Id'     => $lowercasedUsername
        );

        $parameters = new \SSRS\Object\ExecutionParameters($reportParameters);
        $ssrs->setSessionId($result->executionInfo->ExecutionID)->setExecutionParameters($parameters);        
        $output = $ssrs->render('HTML4.0'); // PDF | XML | CSV
        echo $output;
    }

    function CustomSVR_SalesViewReportViewList()
    {
        parent::ViewList();
    }

    function display()
    {
        $this->lv->multiSelect = false;
        $this->lv->delete = false;
        $this->lv->select = false;
        $this->lv->export = false;
        $this->lv->mailMerge = false;
        $this->lv->email = false;
        $this->lv->quickViewLinks = false;

        echo '<style type="text/css">.list .filterContainer {display: none;} .list p.msg {display:none;} .view {background: transparent;} .paginationTable {display: none;} #MassAssign_SecurityGroups {display: none;}</style>';
    }
}

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

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once('include/MVC/View/views/view.list.php');


class CustomBR_BudgetReportViewList extends ViewList
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    function listViewProcess()
    {
        $this->processSearchForm();
        $this->lv->searchColumns = $this->searchForm->searchColumns;

        if (!$this->headers)
            return;
        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
            $this->lv->ss->assign("SEARCH", true);
            $this->lv->ss->assign('savedSearchData', $this->searchForm->getSavedSearchData());
            $this->lv->setup($this->seed, 'custom/modules/BR_BudgetReport/ListView/ListViewGenericReports.tpl', $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display();
        }
    }

    function prepareSearchForm(){
        parent::prepareSearchForm();
        $this->searchForm->displaySavedSearch = false;

        // Force search filter to basic search
        if($_REQUEST['searchFormTab'] <> 'basic_search')
        {
            $requestArray =  array(
                'searchFormTab' => 'basic_search',
                'query' => 'true',
                'orderBy' => '',
                'sortOrder' => '',
                'button' => 'Search'
            );

            $this->searchForm->populateFromArray($requestArray);
            $this->searchForm->populateFromArray($this->searchForm->storeQuery);
        }
    }

    function display()
    {
        global $current_user, $sugar_config;

        $this->lv->export = false;
        $this->lv->delete = false;
        $this->lv->select = false;
        $this->lv->mailMerge = false;
        $this->lv->email = false;
        $this->lv->multiSelect = false;
        $this->lv->quickViewLinks = false;
        $this->lv->mergeduplicates = false;
        $this->lv->contextMenus = false;
        $this->lv->showMassupdateFields = false;
        
        $sum = BudgetReportQuery::budgetReportSumQuery($this);
        $_SESSION['BudgetReportQuerySum'] = $sum;
        
        $this->lv->ss->assign("sum", $sum);
        $defaultConfigMaxEntries = $sugar_config['list_max_entries_per_page'];

        $sugar_config['list_max_entries_per_page'] = '9999999';
        parent::display();
        $sugar_config['list_max_entries_per_page'] = $defaultConfigMaxEntries;
        
        echo <<<EOF
            <style type="text/css">
                #massassign_form {display: none;} 

                .columnsFilterLink {display: none;}

                .selectActionsDisabled { display: none !important; }
            </style>
EOF;

        echo <<<EOF
            <script type="text/javascript">
                var paginationActionButtons = $('.paginationActionButtons:eq(0)');
                var paginationActionButtonsHTML = paginationActionButtons.html();
                var buttonHTML = '<ul class="clickMenu selectmenu columnsFilterLink SugarActionMenu listViewLinkButton listViewLinkButton_top export-pdf">' +
                    '<li class="sugar_action_button">' +
                    '<a href="index.php?entryPoint=BudgetReport" title="Export as PDF" class="parent-dropdown-handler" target="_blank">' +
                        '<span class="glyphicon glyphicon-export glyphicon-icon-cstm"></span>&nbsp;' +
                        '<span>Export PDF</span>' +
                    '</a></li></ul>';
                
                $("#searchDialog").find("ul[role='tablist']").css('display', 'none');
                $('.paginationActionButtons:eq(0)').html(paginationActionButtonsHTML + buttonHTML);
                $('.paginationActionButtons:eq(4)').html(paginationActionButtonsHTML + buttonHTML);
                
                $('.columnsFilterLink:eq(0)').css('display', 'none');
                $('.columnsFilterLink:eq(2)').css('display', 'none');
            </script>
EOF;
        
    }
}

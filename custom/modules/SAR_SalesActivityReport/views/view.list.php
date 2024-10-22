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


class CustomSAR_SalesActivityReportViewList extends ViewList
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
            $this->lv->setup($this->seed, 'custom/modules/SAR_SalesActivityReport/ListView/ListViewGenericReports.tpl', $this->where, $this->params);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display();
        }
    }

    function prepareSearchForm(){
        
        parent::prepareSearchForm();
        $this->searchForm->displaySavedSearch = false;

        $datesArray = retrieveStartAndEndOfWeekDates();

        if(!array_key_exists('date_from_c_basic', $_REQUEST))
        {
            $request =  array('module' => 'SAR_SalesActivityReport',
              'action' => 'index',
              'searchFormTab' => 'basic_search',
              'query' => 'true',
              'orderBy' => '',
              'sortOrder' => '',
              'date_from_c_basic' => $datesArray['startOfWeek'],
              'date_to_c_basic' => $datesArray['endOfWeek'],
              'button' => 'Search',);
             $this->searchForm->populateFromArray($request);
             $this->searchForm->populateFromArray($this->searchForm->storeQuery);
        }
    }

    function processSearchForm()
    {


        parent::processSearchForm();
    }

    function display()
    {
        global $current_user, $sugar_config;

        $this->lv->export = false;
        $this->lv->delete = false;
        $this->lv->select = true;
        $this->lv->mailMerge = false;
        $this->lv->email = false;
        $this->lv->multiSelect = true;
        $this->lv->quickViewLinks = false;
        $this->lv->mergeduplicates = false;
        $this->lv->contextMenus = false;
        $this->lv->showMassupdateFields = false;

        $this->lv->ss->assign("current_user_name", $current_user->first_name . " " . $current_user->last_name);

        $sales_activity_report_pdf_link = $sugar_config['site_url'] . '/index.php?entryPoint=SalesActivityReport';

        $defaultConfigMaxEntries = $sugar_config['list_max_entries_per_page'];

        $sugar_config['list_max_entries_per_page'] = '9999999';

        $showManagementButton = $this->handleManagementUpdateBtnVisibility();
        $this->lv->ss->assign("show_management_button", $showManagementButton);
        
       

        parent::display();
        $sugar_config['list_max_entries_per_page'] = $defaultConfigMaxEntries;

        echo '<style>'; 
            if (! $current_user->is_admin && $current_user->load_relationship('aclroles')) {
                $loggedUserRoleIds = $current_user->aclroles->get();
                $implodedIds = implode(',', $loggedUserRoleIds);
                $roleIdsWhereIn = formatDataArrayForWhereInQuery($implodedIds);

                if ($this->checkIfRoleIsSalesSupervisor($roleIdsWhereIn)) {
                    echo '#selectLinkTop .suitepicon-action-caret { display:none }';
                } else {
                    echo '#selectLinkTop {display: none;}';
                }
            } else {
                echo '#selectLinkTop .suitepicon-action-caret { display:none }';
            }
        echo '</style>';
        
        echo <<<EOF
            <style type="text/css">
                #massassign_form {display: none;} 
                
                .columnsFilterLink {display: none;}

                .selectActionsDisabled { display: none !important; }

                .SugarActionMenu:first-child .sugar_action_button:first-child {margin-right: 0px;}

                ul.searchAppliedAlert.clickMenu.selectmenu.searchAppliedAlertLink.SugarActionMenu.listViewLinkButton.listViewLinkButton_top {
                    margin-right: 5px;
                }

                .custom-dropdown-menu {
                    border-radius: 4px !important;
                    min-width: auto !important;
                    background-color: var(--custom-panel-bg) !important;
                    color: var(--custom-panel-text-color) !important;
                    line-height: 24px !important;

                }
                
                .custom-dropdown-menu, .custom-dropdown-menu > li{
                    padding: 0 !important;
                    margin: 0 !important;
                    border: 0 !important;
                    background-color: var(--custom-panel-bg) !important;
                    color: var(--custom-panel-text-color) !important;
                    line-height: 24px !important;
                    font-weight: normal !important;
                }

                .custom-dropdown-link {
                    margin: 0 !important;
                    padding: 5px 15px !important;
                    background-color: var(--custom-panel-bg) !important;
                    color: var(--custom-panel-text-color) !important;
                    line-height: 24px !important;
                    width: 100% !important;
                }
                
                .custom-dropdown-link:hover {
                    display: block  !important;
                    color: var(--custom-panel-text-color)  !important;
                    float: none  !important;
                    background-color: var(--custom-panel-hover)  !important;
                    width: 100%  !important;
                }

            </style>
EOF;
        
        echo <<<EOF
            <script type="text/javascript">
                $(document).ready( function() {
                    $("#actionLinkTop").remove();
                    
                    var paginationActionButtons = $('.paginationActionButtons:eq(0)');
                    var paginationActionButtonsHTML = paginationActionButtons.html();
                    var buttonHTML = '<div class="btn-group"><button class="btn btn-default btn-sm dropdown-toggle export-menu-btn disabled" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> EXPORT <span class="caret"></span> </button> <ul class="dropdown-menu custom-dropdown-menu"> <li><a class="custom-dropdown-link csv-export" href="#">Export to CSV</a></li> <li><a class="custom-dropdown-link pdf-export" href="#">Export to PDF</a></li> </ul> </div>';

                    $('.paginationActionButtons:eq(0)').html(paginationActionButtonsHTML + buttonHTML);
                    $('.paginationActionButtons:eq(4)').html(paginationActionButtonsHTML + buttonHTML);

                    $('.columnsFilterLink:eq(0)').css('display', 'none');
                    $('.columnsFilterLink:eq(2)').css('display', 'none');
                    
                    /*
                        li.sugar_action_button > .bootstrap-checkbox - Column checkbox
                        ul#selectLinkTop li.sugar_action_button ul.subnav li > a.menuItem - Column header "Select This Page", "Select All", "Deselect All"
                        .listview-checkbox - List View Checkbox
                    */
                    $("li.sugar_action_button > .bootstrap-checkbox, ul#selectLinkTop li.sugar_action_button ul.subnav li > a.menuItem, .listview-checkbox").on('click', function() {

                        setTimeout(function(){ 
                            if($(".listview-checkbox:checked").length < 1) {
                                $(".export-menu-btn")
                                .addClass('disabled')
                                .removeAttr('onclick');
                            } else {
                                $(".export-menu-btn")
                                .removeClass('disabled')
                                $(".csv-export").attr('onclick', "return sListView.send_form(true, `SAR_SalesActivityReport`, `index.php?entryPoint=SalesActivityReport&export_type=csv`,`Please select at least 1 record to proceed.`)");
                                $(".pdf-export").attr('onclick', "return sListView.send_form(true, `SAR_SalesActivityReport`, `index.php?entryPoint=SalesActivityReport&export_type=pdf`,`Please select at least 1 record to proceed.`)");
                            };
                        }, 10);
                    })
                
                    setTimeout( function() {
                        $(".listview-checkbox.highlight").click();
    
                        $('.listview-checkbox').on('click', function() {
                            let activityName = $(this).attr('activity_name');
                            let activityRecordId = $(this).attr('value');
    
                            $.ajax({
                                    url: "index.php?entryPoint=updateModuleRecordHighlight&to_pdf=1",
                                    data: {
                                        activityName: activityName,
                                        activityRecordId: activityRecordId
                                    },
                                    success: function(result){
                                        var jsonResult = JSON.parse(result);
                                    }
                                });
                            });
                    }, 500);
                })
            </script>
EOF;
        
    }

    private function checkIfRoleIsSalesSupervisor($whereInIds)
    {
        global $db;

        $query = "SELECT count(*) FROM acl_roles WHERE acl_roles.name = 'Sales Supervisor' AND acl_roles.id IN ({$whereInIds}) AND deleted = 0";
		$result = $db->getOne($query);
		
		return ($result) ? true : false;
    }

    private function handleManagementUpdateBtnVisibility()
    {
        global $db, $current_user, $log;

        if ($current_user->is_admin) {
            return true;
        }

        if ($current_user->load_relationship('aclroles')) {
            $loggedUserRoleIds = $current_user->aclroles->get();
            $implodedIds = implode(',', $loggedUserRoleIds);
            $roleIdsWhereIn = formatDataArrayForWhereInQuery($implodedIds);
            

            $query = "SELECT count(*) FROM acl_roles WHERE 
                (acl_roles.name = 'Sales Director' OR acl_roles.name = 'Sales Manager')
                AND acl_roles.id IN ({$roleIdsWhereIn}) AND deleted = 0";
            $result = $db->getOne($query);
        }

		return ($result) ? true : false;
    }
}

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

// error_reporting(E_ERROR | E_WARNING | E_PARSE);

require_once('include/MVC/View/views/view.list.php');


class OPR_OpportunityPipelineReportViewList extends ViewList
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    function getData()
    {
        $data = array();
        global $db, $current_user;

        $query = "SELECT a.`id`,
                    ac.`division_c`,
                    a.`name` AS account_name,
                    o.`name` AS opportunity_name,
                    u.`user_name` AS assigned_user_name,
                    o.`amount` AS full_year_amount,
                    oc.`amount_weighted_c` AS full_year_amount_weighted,
                    o.`date_closed`,
                    o.`sales_stage`,
                    SUBSTRING_INDEX(o.`next_step`,'<br',1) AS next_step
                FROM accounts AS a
                INNER JOIN accounts_cstm AS ac
                    ON ac.`id_c` = a.`id`
                INNER JOIN accounts_opportunities AS ao
                    ON ao.`account_id` = a.`id`
                    AND ao.`deleted` = 0
                INNER JOIN opportunities AS o
                    ON o.`id` = ao.`opportunity_id`
                    AND o.`deleted` = 0
                INNER JOIN opportunities_cstm AS oc
                    ON oc.`id_c` = o.`id`
                INNER JOIN users AS u
                    ON u.id = o.`assigned_user_id`
                WHERE a.`deleted` = 0";

        $result = $db->query($query);

        while( $row = $db->fetchByAssoc($result)){
            $row['next_step'] = htmlspecialchars_decode ($row['next_step']);
            $row['full_year_amount_formatted'] = convert_to_money($row['full_year_amount']);
            $data[] = $row;
        }

        return $data;
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
            $this->lv->setup($this->seed, 'custom/modules/OPR_OpportunityPipelineReport/ListView/ListViewGenericReports.tpl', $this->where, $this->params);
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

    function totalPipeline($data)
    {
        $total = 0;

        foreach ($data as $row) {
            $total += $row['full_year_amount'];
        }

        return $total;
    }

    function display()
    {
        global $current_user, $app_list_strings, $sugar_config;

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

        $this->lv->ss->assign("current_user_name", $current_user->first_name . " " . $current_user->last_name);

        $salesStage = array();

        for($i = 1; $i <= count($app_list_strings["sales_stage_dom"]); $i++)
        {
            $salesStage[] = $i;
        }

        $salesStageAcronyms = [];
        foreach ($app_list_strings["sales_stage_dom"] as $key => $value) {
            if(preg_match_all('/\b(\w)/',strtoupper($value),$matches)) {
                switch ($key) {
                    case 'Sampling':
                        array_push($salesStageAcronyms, 'SP');
                        break;
                    case 'ProductionTrialOrder':
                        array_push($salesStageAcronyms, 'PO');
                        break;
                    default:
                        array_push($salesStageAcronyms, implode('', $matches[1]));
                        break;
                }
            }    
        }
        
        $this->lv->ss->assign("salesStage", $salesStage);
        $this->lv->ss->assign("salesStageAcronyms", $salesStageAcronyms);
        $this->lv->ss->assign("salesStageDOM", $app_list_strings["sales_stage_dom"]);

        $defaultConfigMaxEntries = $sugar_config['list_max_entries_per_page'];

        $sugar_config['list_max_entries_per_page'] = '9999999';
        parent::display();
        $sugar_config['list_max_entries_per_page'] = $defaultConfigMaxEntries;

        $buttons = $this->getButtons();

        echo $buttons;

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
                var buttonHTML = $('.btnContainer').html();
                
                //debugger;

                $('.paginationActionButtons:eq(0)').html(paginationActionButtonsHTML + buttonHTML);
                $('.paginationActionButtons:eq(4)').html(paginationActionButtonsHTML + buttonHTML);

                $('.columnsFilterLink:eq(0)').css('display', 'none');
                $('.columnsFilterLink:eq(2)').css('display', 'none');

                let ctr = 1;

                $(".pipeline-row-data").first().find('td[id^="pipeline-row-data"]').each( function() {
                    let rowDataWidth = $(this).outerWidth() + 'px';
                    let pipelineRowHeader = $("#pipeline-row-header-" + ctr);

                    if (ctr != 9) {
                        pipelineRowHeader.attr('style', pipelineRowHeader.attr('style') + ';' + 'width:' + rowDataWidth + '!important');
                    } else {
                        pipelineRowHeader.attr('style', pipelineRowHeader.attr('style') + ';' + 'width: 320px !important');
                    }
                    
                    ctr++;
                });

                $('.btnAction').click(function(event){
                    event.stopPropagation();
                    var isOpen = $('.btnContainer').hasClass('ddopen');

                    if(!isOpen){
                        $(this).closest('.btnActions').find('.subnav').addClass('ddopen');
                        $(this).closest('.btnActions').find('.subnav').css('display', 'block');
                    }
                    else{
                        $('.btnActions').find('.subnav').removeClass('ddopen');
                        $('.btnActions').find('.subnav').css('display', 'none');
                    }

                });

                $(window).click(function() {
                    $('.btnActions').find('.subnav').removeClass('ddopen');
                    $('.btnActions').find('.subnav').css('display', 'none');
                  });
            </script>
EOF;
        
    }

    private function getButtons(){
        $result = <<<EOF
        <div class="btnContainer" style="display: none;">
            <ul class="clickMenu selectmenu columnsFilterLink SugarActionMenu listViewLinkButton listViewLinkButton_top btnActions">
                <li class="sugar_action_button">
                    <a href="javascript:void(0)" class="parent-dropdown-handler btnAction" title="Actions " onclick="return false;">
                        <div>
                            <label class="selected-actions-label"><span class="glyphicon glyphicon-bookmark" style=""></span>
                                <span class="selected-actions-label-text custom-actions-label-text">Actions</span>
                            </label>
                            <span>
                                <span class="suitepicon suitepicon-action-caret"></span>
                            </span>
                        </div>
                    </a>
                    <ul class="subnav" style="display: none;">
                        <li><a href="index.php?entryPoint=OpportunityPipelineReport" class="">Export to PDF</a></li>
                        <li><a href="index.php?entryPoint=OpportunityPipelineReportXLS" class="parent-dropdown-action-handler">Export to Excel</a></li>
                    </ul>
                    
                </li>
            </ul>
        </div>
EOF;

        return $result;
    }
}

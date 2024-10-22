<?php

require_once 'include/MVC/View/views/view.list.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class OAR_OpportunityAgingReportViewList extends ViewList
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
            $this->lv->setup($this->seed, 'custom/modules/OAR_OpportunityAgingReport/ListView/ListViewGenericReports.tpl', $this->where, $this->params);
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

        self::customSmartyAssignments();
        
        $defaultConfigMaxEntries = $sugar_config['list_max_entries_per_page'];

        $sugar_config['list_max_entries_per_page'] = '9999999';
        parent::display();
        $sugar_config['list_max_entries_per_page'] = $defaultConfigMaxEntries;

        self::customCSS();
        self::customJS();
    }

    function customSmartyAssignments()
    {
        global $app_list_strings;

        $ctr = 1;
        $salesStageCtr = array();
        $salesStages = array();

        foreach ($app_list_strings["sales_stage_dom"] as $key => $value) {
            if (! in_array($key, ['Closed', 'ClosedWon', 'ClosedLost', 'ClosedRejected'])) {
                $salesStageCtr[] = $ctr;
                $salesStages[] = $value;
                $ctr++;
            }
        }
        
        $salesStageCtr['total_open_days'] = 'Total';

        $this->lv->ss->assign("salesStageCtr", $salesStageCtr);
        $this->lv->ss->assign("salesStageDOM", $salesStages);
    }

    function customCSS()
    {
        echo "
            <style type='text/css'>
                #massassign_form, .columnsFilterLink, #MassAssign_SecurityGroups {display: none;}

                .selectActionsDisabled { display: none !important; }
            </style>
        ";
    }

    function customJS()
    {
        echo "
            <script type=\"text/javascript\">
                var paginationActionButtons = $('.paginationActionButtons:eq(0)');
                var paginationActionButtonsHTML = paginationActionButtons.html();
                var buttonHTML = '<ul class=\"clickMenu selectmenu columnsFilterLink SugarActionMenu listViewLinkButton listViewLinkButton_top export-pdf\">' +
                    '<li class=\"sugar_action_button\">' +
                    '<a href=\"index.php?entryPoint=OpportunityAgingReport\" title=\"Export as Excel\" class=\"parent-dropdown-handler\" target=\"_blank\">' +
                        '<span class=\"glyphicon glyphicon-export glyphicon-icon-cstm\"></span>&nbsp;' +
                        '<span>Export to Excel</span>' +
                    '</a></li></ul>';
                
                $(\"#searchDialog\").find(\"ul[role='tablist']\").css('display', 'none');
                $('.paginationActionButtons:eq(0)').html(paginationActionButtonsHTML + buttonHTML);
                $('.paginationActionButtons:eq(4)').html(paginationActionButtonsHTML + buttonHTML);
                
                $('.columnsFilterLink:eq(0)').css('display', 'none');
                $('.columnsFilterLink:eq(2)').css('display', 'none');

                let ctr = 1;

                $(\".row-data\").first().find('td[id^=\"row-data\"]').each( function() {
                    let rowDataWidth = ($(this).outerWidth() - 0.255) + 'px';
                    let rowHeader = $(\"#row-header-\" + ctr);

                    if (ctr == 1) {
                        rowDataWidth = ($(this).outerWidth() - .65) + 'px';
                        rowHeader.attr('style', rowHeader.attr('style') + ';' + 'width:' + rowDataWidth + '!important');
                    } else if (ctr == 3 || ctr == 5) {
                        rowDataWidth = ($(this).outerWidth() + .25) + 'px';
                        rowHeader.attr('style', rowHeader.attr('style') + ';' + 'width:' + rowDataWidth + '!important');
                    } else if (ctr == 6) {
                        rowDataWidth = '320px';
                        rowHeader.attr('style', rowHeader.attr('style') + ';' + 'width:' + rowDataWidth + '!important');
                    } else {
                        rowHeader.attr('style', rowHeader.attr('style') + ';' + 'width:' + rowDataWidth + '!important');
                    }

                    ctr++;
                });
            </script>
        ";
    }
}
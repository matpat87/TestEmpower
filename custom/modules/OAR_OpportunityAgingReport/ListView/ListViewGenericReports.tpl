{*
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */
*}
{sugar_include include=$includes}
{include file='include/ListView/ListViewColumnsFilterDialog.tpl'}
<script type='text/javascript' src='{sugar_getjspath file='include/javascript/popup_helper.js'}'></script>

<style>
{literal}
    tr.oddListRowS1:hover td,
    tr.evenListRowS1:hover td {
        background: #f8f9fa !important;
    }

    .thcstm{
        text-align: center !important; 
        background-color: white; 
        color: #534d64 !important;
    }

    .glyphicon-icon-cstm{
        
        font-size: 12px;
    }

    @-moz-document url-prefix() {
        .export-pdf{
            margin-top: -18.5px !important;
        }
    }

    .border-cell {
        border: 1px solid black !important;
    }

    #list-rows > tbody > tr > td {
        margin: 0px;
        padding: 0px;
    }

    .list-rows-sales-stage td{
        text-align: center;
        width: 10%;
    }

    .paginationActionButtons > ul {
        float: none;
    }
    
    li.sugar_action_button {
        margin: 0 !important;
    }
{/literal}
</style>

<script>
{literal}
    $(document).ready(function(){
        $("ul.clickMenu").each(function(index, node){
            $(node).sugarActionMenu();
        });

        $('.selectActionsDisabled').children().each(function(index) {
            $(this).attr('onclick','').unbind('click');
        });

        var selectedTopValue = $("#selectCountTop").attr("value");
        if(typeof(selectedTopValue) != "undefined" && selectedTopValue != "0"){
            sugarListView.prototype.toggleSelected();
        }
    });
{/literal}
</script>

{assign var="currentModule" value = $pageData.bean.moduleDir}
{assign var="singularModule" value = $moduleListSingular.$currentModule}
{assign var="moduleName" value = $moduleList.$currentModule}
{assign var="hideTable" value=false}

{if $form.headerTpl}
    {sugar_include type="smarty" file=$form.headerTpl}
{/if}

{if count($data) == 0}
    {assign var="hideTable" value=true}
    <div class="list view listViewEmpty">
        {if $showFilterIcon}
            <div class="filterContainer">
                {include file='include/ListView/ListViewSearchLink.tpl'}
            </div>
        {/if}
        {if $displayEmptyDataMesssages}
        {if strlen($query) == 0}
                {capture assign="createLink"}<a href="?module={$pageData.bean.moduleDir}&action=EditView&return_module={$pageData.bean.moduleDir}&return_action=DetailView">{$APP.LBL_CREATE_BUTTON_LABEL}</a>{/capture}
                {capture assign="importLink"}<a href="?module=Import&action=Step1&import_module={$pageData.bean.moduleDir}&return_module={$pageData.bean.moduleDir}&return_action=index">{$APP.LBL_IMPORT}</a>{/capture}
                {capture assign="helpLink"}<a target="_blank" href='?module=Administration&action=SupportPortal&view=documentation&version={$sugar_info.sugar_version}&edition={$sugar_info.sugar_flavor}&lang=&help_module={$currentModule}&help_action=&key='>{$APP.LBL_CLICK_HERE}</a>{/capture}
                <p class="msg">
                    Please set filter(s) for the report to display. No report will be shown if there is no data to display.
                </p>
        {elseif $query == "-advanced_search"}
            <p class="msg emptyResults">
                {$APP.MSG_LIST_VIEW_NO_RESULTS_CHANGE_CRITERIA}
            </p>
        {else}
            <p class="msg">
                {capture assign="quotedQuery"}"{$query}"{/capture}
                {$APP.MSG_LIST_VIEW_NO_RESULTS|replace:"<item1>":$quotedQuery}
            </p>
            {if $pageData}
            <p class="submsg">
                <a href="?module={$pageData.bean.moduleDir}&action=EditView&return_module={$pageData.bean.moduleDir}&return_action=DetailView">
                    {$APP.MSG_LIST_VIEW_NO_RESULTS_SUBMSG|replace:"<item1>":$quotedQuery|replace:"<item2>":$singularModule}
                </a>
            </p>
            {/if}
        {/if}
    {else}
        <p class="msg">
            {$APP.LBL_NO_DATA}
        </p>
    {/if}
    </div>
{/if}
{$multiSelectData}

{if $hideTable == false}
    <div class="list-view-rounded-corners">
        <table cellpadding='0' cellspacing='0' border='0' class='list view table-responsive' style="width: max-content; ">
            <thead>
                {assign var="link_select_id" value="selectLinkTop"}
                {assign var="link_action_id" value="actionLinkTop"}
                {assign var="actionsLink" value=$actionsLinkTop}
                {assign var="selectLink" value=$selectLinkTop}
                {assign var="action_menu_location" value="top"}
                {assign var="salesPersonName" value=""}

                {include file='themes/SuiteP/include/ListView/ListViewPaginationTop.tpl'}

            </thead>

            <tbody style="border: 2px solid black; display: block;">
                <tr style="width: 100%">
                    <td style="vertical-align: top; font-weight: bold; font-size: 18px; text-align: center">
                        Opportunity Aging Report
                    </td>
                </tr>
                <tr style="width: 100%">
                    <td style="width: 100%" colspan="6">
                        <table id="list-rows" style="width: 100%;">
                            <thead style="display: block;">
                                <tr class="row-header" style="padding: 0">
                                    <th id="row-header-1" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Opp ID #</th>
                                    <th id="row-header-2" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Opportunity</th>
                                    <th id="row-header-3" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Account</th>
                                    <th id="row-header-4" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Type</th>
                                    <th id="row-header-5" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Value</th>
                                    
                                    <th id="row-header-6" style=" white-space: unset; height: 58px; padding: 0%;" class="border-cell">
                                        <table style="width: 100%; padding: 0%;">
                                            <tbody style="display: block;">
                                                <tr style="display: block;">
                                                    <td style="display: block;text-align: center; padding: 0;">Sales Stage*</td>
                                                </tr>
                                                <tr style="display: block;">
                                                    <td style="display: block; padding: 0%;">
                                                        <div style="display: flex; align-items: center;">
                                                            {foreach name=rowIteration from=$salesStageCtr item=ctr}
                                                                {if $salesStageCtr|@end == $ctr}
                                                                    <span class="text-center" style="width: 100%; border: 1px solid black; border-left: 0; border-bottom: 0; border-right: 0px; height: 29px; padding: 0.55px; padding-top: 5px; margin: -10px 0;">{$ctr}</span>
                                                                {else}
                                                                    <span class="text-center" style="width: 100%; border: 1px solid black; border-left: 0; border-bottom: 0; height: 29px; padding: 0.55px; padding-top: 5px; margin: -10px 0;">{$ctr}</span>
                                                                {/if}
                                                            {/foreach}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody style="display: block; overflow-y: scroll; overflow-x: hidden; max-height: 500px;">
                                {foreach name=rowIteration from=$data key=id item=rowData}
                                    {if $salesPersonName != $rowData.SALES_REP}
                                        {assign var="salesPersonName" value=$rowData.SALES_REP}                            
                                    {/if}
                                    
                                    {if $id > 0}
                                        {assign var="previousKey" value=$id-1}
                                    {else}
                                        {assign var="previousKey" value=$id}
                                    {/if}
                                    
                                    {if $id == 0 || $id > 0 && $data[$id].SALES_REP != $data[$previousKey].SALES_REP}
                                        <tr>
                                            <td><span style="font-size: 18px; font-family: inherit; font-weight: 500; line-height: 1.1; color: inherit; display: block; margin: 0; margin-top: 10px; padding-left: 4px; margin-bottom: 2px;">{$salesPersonName}</span></td>
                                        </tr>
                                    {/if}
                                    
                                    <tr class="row-data">
                                        <td id="row-data-1" class="border-cell" style="text-align: center; margin-left: 5px; margin-right: 5px; width: 100px;"><a href="{$rowData.OPPORTUNITY_LINK}">{$rowData.OPPORTUNITY_ID_NUMBER}</a></td>
                                        <td id="row-data-2" class="border-cell"><div style="margin-left: 5px; margin-right: 5px; width: 150px;">{$rowData.OPPORTUNITY_NAME}</div></td>
                                        <td id="row-data-3" class="border-cell"><div style="margin-left: 5px; margin-right: 5px; width: 150px;">{$rowData.ACCOUNT_NAME}</div></td>
                                        <td id="row-data-4" class="border-cell"><div style="margin-left: 5px; margin-right: 5px; width: 150px;">{$rowData.OPPORTUNITY_TYPE}</div></td>
                                        <td id="row-data-5" class="border-cell"><div style="margin-left: 5px; margin-right: 5px; width: 100px;">${$rowData.OPPORTUNITY_VALUE|number_format:2:".":","}</div></td>

                                        <td id="row-data-6" class="border-cell" style="padding: 0%; width: 320px;">
                                            <div style="display: flex; align-items: center;">
                                                {foreach name=salesStageIteration from=$salesStageCtr key=id item=salesStageValue}
                                                    {assign var="sales_stage_num" value="SALES_STAGE_{$salesStageValue}"}

                                                    {if $salesStageCtr|@end == $salesStageValue}
                                                        <span class="text-center" style="width: 100%; border-right: 1px solid black;  padding: 2.5vh 0.55px;">{$rowData.SALES_STAGE_TOTAL}</span>
                                                    {else}
                                                        <span class="text-center" style="width: 100%; border-right: 1px solid black;  padding: 2.5vh 0.55px;">{$rowData.$sales_stage_num}</span>
                                                    {/if}
                                                {/foreach}

                                                
                                            </div>
                                        </td>
                                    </tr>
                                {/foreach}
                            </tbody>
                            <tfoot style="display: block;border: 1px solid black;">
                                <tr>
                                    <td colspan="6" style="padding: 0px; padding-left: 5px; padding-top: 3px; font-size: 11px; font-weight: 700;">* Sales Stages (NOTE: Some stages may occur out of order or not at all):</td>
                                </tr>
                                <tr>
                                    <td colspan="6"  style="padding: 0px;">
                                        <table>
                                            <tr>
                                                {assign var="ctrSalesStageDOM" value=1}
                                                {foreach name=salesStageDOMIteration from=$salesStageDOM key=id item=salesStageValue}
                                                
                                                    <td style="font-size: 11px;">{$ctrSalesStageDOM}) {$salesStageValue}</td>
                                                    {assign var="ctrSalesStageDOM" value=$ctrSalesStageDOM+1}
                                                {/foreach}
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
                
                {assign var="link_select_id" value="selectLinkBottom"}
                {assign var="link_action_id" value="actionLinkBottom"}
                {assign var="selectLink" value=$selectLinkBottom}
                {assign var="actionsLink" value=$actionsLinkBottom}
                {assign var="action_menu_location" value="bottom"}
            </tbody>

            <tfoot>
                {include file='themes/SuiteP/include/ListView/ListViewPaginationBottom.tpl'}
            </tfoot>
        </table>
    </div>
{/if}
{if $contextMenus}
<script type="text/javascript">
{$contextMenuScript}
{literal}
function lvg_nav(m,id,act,offset,t){
  if (t.href.search(/#/) < 0) {
  }
    else{
        if(act=='pte'){
            act='ProjectTemplatesEditView';
        }
        else if(act=='d'){
            act='DetailView';
        }else if( act =='ReportsWizard'){
            act = 'ReportsWizard';
        }else{
            act='EditView';
        }
    {/literal}
        url = 'index.php?module='+m+'&offset=' + offset + '&stamp={$pageData.stamp}&return_module='+m+'&action='+act+'&record='+id;
        t.href=url;
    {literal}
    }
}{/literal}
{literal}
    function lvg_dtails(id){{/literal}
        return SUGAR.util.getAdditionalDetails( '{$pageData.bean.moduleDir|default:$params.module}',id, 'adspan_'+id);{literal}}{/literal}
</script>
<script type="text/javascript" src="include/InlineEditing/inlineEditing.js"></script>
{/if}

{if $form.footerTpl}
    {sugar_include type="smarty" file=$form.headerTpl}
{/if}

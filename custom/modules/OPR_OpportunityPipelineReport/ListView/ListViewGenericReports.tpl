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

    #pipeline-info td{
        border: 1px solid black;
    }

    .border-cell
    {
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
{assign var="salesStageStart" value=1}
{assign var="salesStageEnd" value=10}
{assign var="salesStageEnd" value=10}

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
{*$data|var_dump*}
{if $hideTable == false}

    <div class="list-view-rounded-corners">
        <table cellpadding='0' cellspacing='0' border='0' class='list view table-responsive' style="width: max-content; ">
    <thead>
        {assign var="link_select_id" value="selectLinkTop"}
        {assign var="link_action_id" value="actionLinkTop"}
        {assign var="actionsLink" value=$actionsLinkTop}
        {assign var="selectLink" value=$selectLinkTop}
        {assign var="action_menu_location" value="top"}
        {assign var="fullYearAmountTotal" value=0}
        {assign var="fullYearAmountTotalWeighted" value=0}
        {assign var="rowCtr" value=0}
        {assign var="salesPersonName" value=""}
        {assign var="subTotal" value=0}
        {assign var="subTotalWeighted" value=0}

        {include file='themes/SuiteP/include/ListView/ListViewPaginationTop.tpl'}

    </thead>
    <tfoot style="border: 2px solid black; display: block;">
        <tr style="width: 100%">
            <td>
                <table id="pipeline-info">
                    <tr>
                        {foreach name=rowIteration from=$data key=id item=rowData}
                            {if $rowCtr == 0}
                                {assign var="salesPersonName" value=$rowData.SALES_REP}
                            {/if}

                            {assign var="fullYearAmountTotal" value=$fullYearAmountTotal+$rowData.AMOUNT_VALUE}
                            {assign var="fullYearAmountTotalWeighted" value=$fullYearAmountTotalWeighted+$rowData.AMOUNT_WEIGHTED_VALUE}
                            {assign var="rowCtr" value=$rowCtr+1}
                        {/foreach}
                        <tr>
                            <td>Pipeline Total</td>
                            <td>${$fullYearAmountTotal|number_format:2:".":","}</td>
                        </tr>
                        <tr>
                            <td>Pipeline Total (Weighted)</td>
                            <td>${$fullYearAmountTotalWeighted|number_format:2:".":","}</td>
                        </tr>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top;">
                <table>
                    <tr>
                        <td style="text-align: center;"></td>
                    </tr>
                    <tr>
                       <td style="font-weight: bold; font-size: 18px;">
                           Consolidated Sales Pipeline
                       </td> 
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top; text-align: right; font-weight: bold; font-size: 16px">CONFIDENTIAL</td>
        </tr>
        <tr style="width: 100%">
            <td style="width: 100%" colspan="3">

                <table id="list-rows" style="width: 100%;">
                    <thead style="display: block;">
                        <tr class="pipeline-row-header" style="padding: 0">
                            <th id="pipeline-row-header-1" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Opp ID #</th>
                            <th id="pipeline-row-header-2" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Opportunity</th>
                            <th id="pipeline-row-header-3" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Account</th>
                            <th id="pipeline-row-header-4" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Status</th>
                            <th id="pipeline-row-header-5" style="text-align: center;  height: 58px; white-space: unset;" class="border-cell">Full-Year Value</th>
                            <th id="pipeline-row-header-6" style="text-align: center;  height: 58px; white-space: unset;" class="border-cell">Created Date</th>
                            <th id="pipeline-row-header-7" style="text-align: center;  height: 58px; white-space: unset; padding-top: 17px;" class="border-cell">Close Date</th>
                            
                            <th id="pipeline-row-header-8" style=" white-space: unset; height: 58px; padding: 0%;" class="border-cell">
                                <table style="width: 100%; padding: 0%;">
                                    <tbody style="display: block;">
                                        <tr style="display: block;">
                                            <td style="display: block;text-align: center; padding: 0;">Sales Stage*</td>
                                        </tr>
                                        <tr style="display: block; ">
                                            <td style="display: block; padding: 0%;">
                                                <table style="width: 100%; ">
                                                    <tbody style="display: block;">
                                                        <tr style="display: block; padding: 0.55px; margin: -10px 0;">
                                                            {foreach name=rowIteration from=$salesStageAcronyms key=id item=salesStageAcronym}
                                                                
                                                                {if $salesStageAcronyms|@end == $salesStageAcronym}
                                                                    <td style="padding: 5px 0px; margin: 0; border: 1px solid black; width: 100%;" class="text-center">&nbsp;{$salesStageAcronym}&nbsp;</td>
                                                                {else}
                                                                    <td style="padding: 5px 0px; margin: 0; border: 1px solid black;" class="text-center">&nbsp;{$salesStageAcronym}&nbsp;</td>
                                                                {/if}
                                                            {/foreach}
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </th>
                            
                            <th id="pipeline-row-header-9" style="height: 58px; padding-top: 17px;" class="border-cell"><font style="word-wrap:break-word;">Next Actions, Status - specific, measurable, dates</font></th>
                        </tr>
                    </thead>
                    <tbody style="display: block; overflow-y: scroll; overflow-x: hidden; max-height: 500px;">
                        {foreach name=rowIteration from=$data key=id item=rowData}

                        {if $salesPersonName != $rowData.SALES_REP}
                            <tr>
                                <td colspan="5" class="border-cell" style="text-align: right; background-color: white;">
                                    <font style="margin-right: 10px; color: black; font-size: 12px;">SubTotal: ${$subTotal|number_format:2:".":","}</font>
                                </td>
                                <td colspan="5" class="border-cell" style="text-align: left; background-color: white;">
                                    <font style="margin-left: 10px; color: black; font-size: 12px;">SubTotal (Weighted) ${$subTotalWeighted|number_format:2:".":","}</font>
                                </td>
                            </tr>

                            {assign var="subTotal" value=0}
                            {assign var="subTotalWeighted" value=0}
                            {assign var="salesPersonName" value=$rowData.SALES_REP}                            
                        {/if}
                        
                        {if $id > 0}
                            {assign var="previousKey" value=$id-1}
                        {else}
                            {assign var="previousKey" value=$id}
                        {/if}
                        
                        {if $id == 0 || $id > 0 && $data[$id].SALES_REP != $data[$previousKey].SALES_REP}
                            <tr>
                                <td><h4>{$salesPersonName}</h4></td>
                            </tr>
                        {/if}
                        
                        <tr class="pipeline-row-data">
                            <td id="pipeline-row-data-1" class="border-cell" style="text-align: center;"><a href="{$rowData.OPPORTUNITY_LINK}">{$rowData.OPPORTUNITY_ID_NUM}</a></td>
                            <td id="pipeline-row-data-2" class="border-cell"><div style="margin-left: 5px; width: 133px;">{$rowData.OPPORTUNITY_NAME}</div></td>
                            <td id="pipeline-row-data-3" class="border-cell"><div style="margin-left: 5px; width: 162px;">{$rowData.ACCOUNT_C}</div></td>
                            <td id="pipeline-row-data-4" class="border-cell"><div style="margin-left: 5px; width: 100px;">{$rowData.STATUS}</div></td>
                            <td id="pipeline-row-data-5" class="border-cell" style="text-align: right; width: 99px;"><div style="margin-right: 5px;">{$rowData.FULL_YEAR_AMOUNT}</div></td>
                            <td id="pipeline-row-data-6" class="border-cell"><div style="margin-left: 5px; width: 77px;">{$rowData.CREATED_DATE}</div></td>
                            <td id="pipeline-row-data-7" class="border-cell"><div style="margin-left: 5px; width: 113px;">{$rowData.DATE_CLOSED}</div></td>
                            <td id="pipeline-row-data-8" class="border-cell" style="padding: 0%; width: 245px;">
                                <table class="list-rows-sales-stage" style="width: 100%; height: 100%; ">

                                    <tr style="height: 100% !important">
                                        {foreach name=salesStageIteration from=$salesStage key=id item=salesStageValue}
                                            {if $salesStageValue == ($rowData.SALES_STAGE)}
                                                {if $salesStageValue <= 8}
                                                    <td class="text-center border-cell" style="background-color: #7dc2fa;">X</td>
                                                {elseif $salesStageValue == 9}
                                                    <td class="text-center border-cell" style="background-color: #80B440;">X</td>
                                                {elseif $salesStageValue == 10}
                                                    <td class="text-center border-cell" style="background-color: red;">X</td>
                                                {elseif $salesStageValue == 11}
                                                    <td class="text-center border-cell" style="background-color: orange;">X</td>
                                                {/if}
                                            {else}
                                                <td class="text-center border-cell">&nbsp;-</td>
                                            {/if}
                                        {/foreach}
                                    </tr>
                                </table>
                            </td>
                            <td id="pipeline-row-data-9" class="border-cell next-step"><div style="margin-left: 5px; width: 305px;">{$rowData.NEXT_STEP}</div></td>
                        </tr>

                        {assign var="subTotal" value=$subTotal+$rowData.AMOUNT_VALUE}
                        {assign var="subTotalWeighted" value=$subTotalWeighted+$rowData.AMOUNT_WEIGHTED_VALUE }
                        {assign var="rowCtr" value=$rowCtr+1}
                        {/foreach}

                        {if $subTotal >= 0 || $subTotalWeighted >= 0}
                            <tr>
                                <td colspan="5" class="border-cell" style="text-align: right; background-color: white;">
                                    <font style="margin-right: 10px; color: black; font-size: 12px;">SubTotal: ${$subTotal|number_format:2:".":","}</font>
                                </td>
                                <td colspan="5" class="border-cell" style="text-align: left; background-color: white;">
                                    <font style="margin-left: 10px; color: black; font-size: 12px;">SubTotal (Weighted) ${$subTotalWeighted|number_format:2:".":","}</font>
                                </td>
                            </tr>

                            {assign var="subTotal" value=0}
                            {assign var="subTotalWeighted" value=0}
                            {assign var="salesPersonName" value=$rowData.SALES_REP}
                        {/if}

                        <tr>
                            <td colspan="5" class="border-cell" style="text-align: right; background-color: black;">
                                <font style="margin-right: 10px; color: white; font-size: 14px;">CONSOLIDATED TOTAL ${$fullYearAmountTotal|number_format:2:".":","}</font>
                            </td>
                            <td colspan="5" class="border-cell" style="text-align: left; background-color: black;">
                                <font style="margin-left: 10px; font-weight: bold; color: white; font-size: 14px;">CONSOLIDATED TOTAL (WEIGHTED) ${$fullYearAmountTotalWeighted|number_format:2:".":","}</font>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot style="display: block;border: 1px solid black;">
                        <tr>
                            <td colspan="9" style="padding: 0px; padding-left: 5px; padding-top: 3px; font-size: 11px; font-weight: 700;">* Sales Stages (NOTE: Some stages may occur out of order or not at all):</td>
                        </tr>
                        <tr>
                            <td colspan="9"  style="padding: 0px;">
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
    </tfoot>
    <tfoot>
    {include file='themes/SuiteP/include/ListView/ListViewPaginationBottom.tpl'}
    </tfoot>
    </table></div>
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

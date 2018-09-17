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
    .oddListRowS1 td{
        background-color: white !important;
    }

    .thcstm{
        text-align: center !important; 
        background-color: white; 
        color: #534d64 !important;
    }

    .export-pdf a{
        padding: 2px 6px 7px 7px !important;
        
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
                    {$APP.MSG_EMPTY_LIST_VIEW_NO_RESULTS|replace:"<item2>":$createLink|replace:"<item3>":$importLink}
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
        <table cellpadding='0' cellspacing='0' border='0' class='list view table-responsive'>
    <thead>
        {assign var="link_select_id" value="selectLinkTop"}
        {assign var="link_action_id" value="actionLinkTop"}
        {assign var="actionsLink" value=$actionsLinkTop}
        {assign var="selectLink" value=$selectLinkTop}
        {assign var="action_menu_location" value="top"}


        {include file='themes/SuiteP/include/ListView/ListViewPaginationTop.tpl'}

    </thead>
    <tbody style="border: 2px solid black; display: block;">
        <tr style="width: 100%">
            <td>
                <table id="pipeline-info">
                    <tr>
                        <td>Pipeline Total</td>
                        <td>{$fullYearAmountTotal}</td>
                    </tr>
                </table>
            </td>
            <td style="vertical-align: top;">
                <table>
                    <tr>
                        <td style="text-align: center;"><img style="margin-top: 20px;" src="themes/default/images/company_logo.png" /></td>
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
                    <thead>
                        <tr>
                        <th style="width: 20% !important; text-align: center;" class="border-cell">Account</th>
                        <th style="width: 20% !important; text-align: center;" class="border-cell">Opportunity</th>
                        <th style="width: 5% !important; text-align: center;" class="border-cell">Status</th>
                        <th style="width: 5%; text-align: center;" class="border-cell">Sales Rep</th>
                        <th style="width: 8% text-align: center;" class="border-cell">Full-Year Value</th>
                        <th style="width: 5%; text-align: center;" class="border-cell"><div style="text-align: center;">Initial</div><div>Order Date</div></th>
                        <th style="width: 20%; padding: 0%;" class="border-cell">
                            <table style="width: 100%; padding: 0%;">
                                <tr>
                                    <td style="text-align: center;">Sales Stage*</td>
                                </tr>
                                <tr>
                                    <td style="padding: 0%;">
                                        <table style="width: 100%; padding: 0%;">
                                            <tr>
                                                <td class="border-cell">1</td>
                                                <td class="border-cell">2</td>
                                                <td class="border-cell">3</td>
                                                <td class="border-cell">4</td>
                                                <td class="border-cell">5</td>
                                                <td class="border-cell">6</td>
                                                <td class="border-cell">7</td>
                                                <td class="border-cell">8</td>
                                                <td class="border-cell">9</td>
                                                <td class="border-cell">10</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                        </th>
                        <th style="width: 17%" class="border-cell"><font style="word-wrap:break-word;">Next Actions, Status - specific, measurable, dates</font></th>
                        </tr>
                    </thead>
                    <tbody>
                        {foreach name=rowIteration from=$data key=id item=rowData}
                        
                        <tr>
                            <td class="border-cell"><div style="margin-left: 5px;">{$rowData.ACCOUNT_C}</div></td>
                            <td class="border-cell"><div style="margin-left: 5px;">{$rowData.OPPORTUNITY_NAME}</div></td>
                            <td class="border-cell"></td>
                            <td class="border-cell"><div style="margin-left: 5px;">{$rowData.SALES_REP}</div></td>
                            <td class="border-cell" style="text-align: right;"><div style="margin-right: 5px;">{$rowData.FULL_YEAR_AMOUNT}</div></td>
                            <td class="border-cell"><div style="margin-left: 5px;">{$rowData.DATE_CLOSED}</div></td>
                            <td class="border-cell" style="padding: 0%;">
                                <table class="list-rows-sales-stage" style="width: 100%; height: 100%; ">
                                    <tr style="height: 100% !important">
                                        {foreach name=salesStageIteration from=$salesStage key=id item=salesStageValue}
                                            {if $salesStageValue == 0}
                                                <td class="border-cell" style="background-color: #80B440;">X</td>
                                            {else}
                                                <td class="border-cell">-</td>
                                            {/if}
                                        {/foreach}
                                    </tr>
                                </table>
                            </td>
                            <td class="border-cell next-step"><div style="margin-left: 5px;">{$rowData.NEXT_STEP}</div></td>
                        </tr>
                        {/foreach}
                        <tr>
                            <td colspan="4" class="border-cell" style="text-align: right; background-color: black;">
                                <font style="margin-right: 10px; color: white; font-size: 14px;">CONSOLIDATED TOTAL</font>
                            </td>
                            <td colspan="4" class="border-cell" style="text-align: left; background-color: black;">
                                <font style="margin-left: 10px; font-weight: bold; color: white; font-size: 14px;">{$fullYearAmountTotal}</font>
                            </td>
                        </tr>
                    </tbody>
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

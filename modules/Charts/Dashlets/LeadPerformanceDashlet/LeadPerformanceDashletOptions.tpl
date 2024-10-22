{*

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




*}


<div style='width: 500px'>
<form name='configure_{$id}' action="index.php" method="post" onSubmit='submitChartOptions()'>
<input type='hidden' name='id' value='{$id}'>
<input type='hidden' name='module' value='Home'>
<input type='hidden' name='action' value='ConfigureDashlet'>
<input type='hidden' name='to_pdf' value='true'>
<input type='hidden' name='configure' value='true'>
{* <input type='text' name='leads_performance_sales_group_user_ids[]' value='{$leads_performance_sales_group_user_ids}'> *}
<table width="400" cellpadding="0" cellspacing="0" border="0" class="edit view" align="center">
<tr>
    <td valign='top' nowrap class='dataLabel'>{$titleLbl}</td>
    <td valign='top' class='dataField'>
    	<input type="text" class="text" name="title" size='20' value='{$title}'>
    </td>
</tr>

 <tr>
    <td valign='top' nowrap class='dataLabel'>Assigned To</td>
    <td valign="top" style="padding-bottom: 5px">
        <select multiple="true" size="3" id="leads_performance_sales_group_user_ids" name="leads_performance_sales_group_user_ids[]"> 
            {foreach from=$salesGroupUsers key=key item=value} 
                {if $key|in_array:$leads_performance_sales_group_user_ids}
                    <option value="{$key}" selected>{$value}</option>
                {else}
                    <option value="{$key}">{$value}</option>
                {/if}
            {/foreach}
           
        </select>
    </td>
</tr>


<tr>
    <td valign='top' nowrap class='dataLabel'>Date From</td>
    <td valign="top" style='padding-bottom: 5px'>
        <span class="dateTime">
            <input class="date_input" autocomplete="off" type="text" name="lead_performance_date_from" id="lead_performance_date_from" value="{$lead_performance_date_from}" title="" tabindex="0" size="11" maxlength="10">
            <button type="button" id="lead_performance_date_from_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar" alt="Enter Date"></span></button>
        </span>
        <script type="text/javascript">
            Calendar.setup ({ldelim}
                inputField : "lead_performance_date_from",
                ifFormat : "%m/%d/%Y %I:%M%P",
                daFormat : "%m/%d/%Y %I:%M%P",
                button : "lead_performance_date_from_trigger",
                singleClick : true,
                dateStr : "",
                startWeekday: 0,
                step : 1,
                weekNumbers:false
            {rdelim});
        </script>
    </td>
</tr>

<tr>
    <td valign='top' nowrap class='dataLabel'>Date To</td>
    <td valign="top" style='padding-bottom: 5px'>
        <span class="dateTime">
            <input class="date_input" autocomplete="off" type="text" name="lead_performance_date_to" id="lead_performance_date_to" value="{$lead_performance_date_to}" title="" tabindex="0" size="11" maxlength="10">
            <button type="button" id="lead_performance_date_to_trigger" class="btn btn-danger" onclick="return false;"><span class="suitepicon suitepicon-module-calendar" alt="Enter Date"></span></button>
        </span>
        <script type="text/javascript">
            Calendar.setup ({ldelim}
                inputField : "lead_performance_date_to",
                ifFormat : "%m/%d/%Y %I:%M%P",
                daFormat : "%m/%d/%Y %I:%M%P",
                button : "lead_performance_date_to_trigger",
                singleClick : true,
                dateStr : "",
                startWeekday: 0,
                step : 1,
                weekNumbers:false
            {rdelim});
        </script>
    </td>
</tr>

<tr>
    <td align="right" colspan="2">
        <input type='submit' class='button' value='{$saveLbl}'>
   	</td>
</tr>
</table>
</form>
</div>

<script type="text/javascript">
    {literal}
        function submitChartOptions() {
            SUGAR.dashlets.postForm("configure_{/literal}{$id}{literal}", SUGAR.mySugar.uncoverPage);
            return SUGAR.mySugar.retrieveCurrentPage();
        }
    {/literal}
</script>
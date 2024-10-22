{*
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2012 SugarCRM Inc.
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

*}
{* BEGIN - SECURITY GROUPS *}
{* <script src="{sugar_getjspath file='modules/ACLRoles/ACLRoles.js'}"></script>
<script type="text/javascript" src='{sugar_getjspath file ='include/javascript/yui/build/selector/selector-min.js'}'></script> *}
<script language="Javascript" type="text/javascript">
{literal}
function cascadeAccessOption(action,selectEle) {
	var accessOption = selectEle.options[selectEle.selectedIndex].value;
	var accessLabel = selectEle.options[selectEle.selectedIndex].text;
	var nodes = YAHOO.util.Selector.query('.'+action);
	var selectId = '';
	for(i=0; i < nodes.length; i++) {
		selectId = nodes[i].id.substring(8);
//alert('selectId: '+selectId);
		nodes[i].value = accessOption;
		var roleCell = document.getElementById(selectId+'link');
		if(roleCell != undefined) {
			roleCell.innerHTML = accessLabel;
		}		
	}
}
{/literal}
</script>
<style>
{literal}
.act_guid{
    padding-left: 0px !important;
    padding-right: 0px !important;
    width: 75px;
}

#tblModuleManagement{
    table-layout: fixed;
}

#tblModuleManagement tbody tr{
    line-height: 25px;
}
{/literal}
</style>
{* END - SECURITY GROUPS *}
<form method='POST' name='EditView' id='ACLEditView'>
<input type='hidden' name='record' value='{$ROLE.id}'>
<input type='hidden' name='module' value='ACLRoles'>
<input type='hidden' name='action' value='Save'>
<input type='hidden' name='return_record' value='{$RETURN.record}'>
<input type='hidden' name='return_action' value='{$RETURN.action}'>
<input type='hidden' name='return_module' value='{$RETURN.module}'> 
<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="button {$APP.LBL_SAVE_BUTTON_KEY}" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" id="SAVE_HEADER"> &nbsp;
<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"   class='button' accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" type='button' name='cancel' value="  {$APP.LBL_CANCEL_BUTTON_LABEL} " class='button'>
</p>

<div style="height: 50vh; overflow-y: scroll;">

<input type="hidden" name="module_id" id="module_id" value="" />

<table id="tblModuleManagement" width='100%' class='detail view' border='0' cellpadding=0 cellspacing = 1 >
    <thead>
        <tr>
            <th class="thAction" style="max-width: 12%; width: 12% important;">Role</th>
            {foreach from=$ACTION_NAMES item="ACTION" key="ACTION_NAME"}
                <th class="thAction" stlye="width: 12% !important; max-width: 12% !important; padding-left: 0px; padding-right: 0px; text-align: center !important;">
                    <select class="header-action header-action-{$ACTION_NAME} select-hidden" name='header-action-{$ACTION_NAME}' id='header-action-{$ACTION_NAME}'>
                        {html_options options=$ACTION.options }
                    </select>

                    <label class="header-action-name" data-header-label="{$ACTION.label}">{$ACTION.label|ucfirst}</label>
                </th>
            {/foreach}
        </tr>
    </thead>
    <tbody>
          {* {$ACL_ROLE_ACTION_LIST|@var_dump}   *}
        {foreach from=$ACL_ROLE_ACTION_LIST item="ACL_ROLE_ACTION" key="ROLE_ID"}
            <tr>
                <td>{$ACL_ROLE_ACTION.role_name} 
                    <input type="hidden" name="role_id_{$ACL_ROLE_ACTION.role_id}" id="role_id_{$ACL_ROLE_ACTION.role_id}" class="role_id"
                        value="{$ACL_ROLE_ACTION.role_id}" />
                </td>

                {foreach from=$ACL_ROLE_ACTION.access_list item="ACTION" key="ACTION_NAME"}
                    {* {foreach from=$ROLE.module item="ROLE_ACTION" key="ROLE_ACTION_NAME"} *}
                        {* {if $ACTION_NAME==$ROLE_ACTION_NAME} *}
                            <td class="tdAction" stlye="padding-left: 0px; padding-right: 0px;">
                                <select class="act_guid act_guid_{$ACTION.action_name} select-hidden" name='{$ACTION.id}' id='act_guid{$ACTION.id}' 
                                data-actionid="{$ACTION.action_id}" data-actionname="{$ACTION.action_name}" data-modulename="{$ACTION.module_name}"
                                data-prevval="{$ACTION.aclaccess}">
                                    {html_options options=$ACTION.accessOptions selected=$ACTION.aclaccess }
                                </select>

                                <label class="action-name acl{$ACTION.accessLabel|ucfirst}">{$ACTION.accessLabel|ucfirst}</label>

                                {* <div class="acl{$ACTION.accessName}"  id="{$ACTION.id}link" onclick="aclviewer.toggleDisplay('{$ACTION.id}')">{$ACTION.accessName}</div> *}
                                <input type="hidden" name="action_id_{$ACTION.action_id}" id="action_id_{$ACTION.action_id}" class="action_id"
                                    value="{$ACTION.action_id}" />
                            </td>
                        {* {/if} *}
                    {* {/foreach} *}
                {/foreach}
            </tr>
        {/foreach}
    </tbody>
</table>

</div>
<div style="padding-top:10px;">
&nbsp;<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" class="button {$APP.LBL_SAVE_BUTTON_KEY}" type="button" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}  " id="SAVE_FOOTER"> &nbsp;
<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}"   class='button' type='button' name='cancel' value="  {$APP.LBL_CANCEL_BUTTON_LABEL} " class='button' />
</div>
</form>

<script type="text/javascript" src="custom/modules/MDM_ModuleManagement/js/ModuleManagementCore.js"></script>
<script type="text/javascript">
    ModuleManagementCore();
</script>
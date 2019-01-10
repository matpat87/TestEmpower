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

<div style="width:100%;vertical-align:middle;">
<table width="100%" border="0" align="center" class="list view" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th align="center">
				<div style="white-space: normal; width:100%; text-align:left">
					{$lblAccountName}
				</div>
			</th>
			<th align="center">
				<div style="white-space: normal; width:100%; text-align:left">
					{$lblLastActivityDate}
				</div>
			</td>
			<th align="center">
				<div style="white-space: normal; width:100%; text-align:left">
					{$lblPhone}
				</div>
			</td>
			<th align="center">
				<div style="white-space: normal; width:100%; text-align:left">
					{$lblShippingCity}
				</div>
			</td>
			<th align="center">
				<div style="white-space: normal; width:100%; text-align:left">
					{$lblShippingState}
				</div>
			</td>
			<th align="center">
				<div style="white-space: normal; width:100%; text-align:left">
					{$lblShippingYTDSales}
				</div>
			</td>
		</tr>
	</thead>
	{if $myTopTenAccounts}
		{foreach from=$myTopTenAccounts item=accounts}
			<tr class="oddListRowS1">
			    {foreach from=$accounts key=accountKey item=account}
			    	{if $accountKey == 'id'}
			    		{assign var="accountID" value=$account}
			    	{else}
			    		{if $accountKey == 'name'}
				    		<td valign="top">			    			
				    			<a href="index.php?action=DetailView&module=Accounts&record={$accountID}"><strong>{$account}</strong></a>
				    		</td>
				    	{else}
				    		<td valign="top">{$account}</td>
				    	{/if}
			    	{/if}			   			    
			    {/foreach}
		    </tr>
		{/foreach}
	{else}
		<tr class="oddListRowS1">
			<td colspan="16">
				<em>No Data</em>
			</td>
		</tr>
	{/if}
</table>
</div>
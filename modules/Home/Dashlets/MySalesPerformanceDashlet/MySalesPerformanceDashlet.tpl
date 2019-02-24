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
<table width="100%"  align="center" class="list view table table-bordered" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th align="center" style="width:25%">
				<div style="white-space: normal; width:100%; text-align:center; visibility:hidden">
					Sales Performance
				</div>
			</th>
			<th align="center" style="width:25%">
				<div style="white-space: normal; width:100%; text-align:center">
					LY MTD
				</div>	
			</td>
			<th align="center" style="width:25%">
				<div style="white-space: normal; width:100%; text-align:center">
					Current MTD
				</div>	
			</td>
			<th align="center" style="width:25%">
				<div style="white-space: normal; width:100%; text-align:center">
					Budget MTD
				</div>	
			</td>
		</tr>
	</thead>
	
		<tr class="oddListRowS1">
			<td valign="top" class="text-center">
				<div class="row">
					<div class="col-xs-8 margin-top-5">
						<strong>Sales ($)*</strong>
					</div>
					<div class="col-xs-4">
						<span class="dot {$mySalesPerformance.sales_dot_color}"></span>
					</div>
				</div>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.lmy_actual_sales}<span>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.cmy_actual_sales}<span>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.cmy_budget_sales}<span>
			</td>
		</tr>

		<tr class="oddListRowS1">
			<td valign="top" class="text-center">
				<div class="row">
					<div class="col-xs-8 margin-top-5">
						<strong>Margin %</strong>
					</div>
					<div class="col-xs-4">
						<span class="dot {$mySalesPerformance.margin_dot_color}"></span>
					</div>
				</div>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.lmy_actual_margin}<span>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.cmy_actual_margin}<span>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.cmy_budget_margin}<span>
			</td>
		</tr>

		<tr class="oddListRowS1">
			<td valign="top" class="text-center">
				<div class="row">
					<div class="col-xs-8 margin-top-5">
						<strong>Volume (lbs)*</strong>
					</div>
					<div class="col-xs-4">
						<span class="dot {$mySalesPerformance.volume_dot_color}"></span>
					</div>
				</div>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.lmy_actual_volume}<span>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.cmy_actual_volume}<span>
			</td>

			<td class="text-center valign-middle">
				<span>{$mySalesPerformance.cmy_budget_volume}<span>
			</td>
		</tr>
	
</table>
</div>

{literal}

	<style>
	.margin-top-5 {
		margin-top: 5px;
	}
	.dot {
		height: 25px;
		width: 25px;
		border-radius: 50%;
		display: inline-block;
	}
	.dot-gray {
		background-color: #999999;
	}
	.dot-green {
		background-color: #00b300;
	}
	.dot-yellow {
		background-color: #ffff33;
	}
	.dot-red {
		background-color: #ff3333;
	}
	.valign-middle {
		vertical-align: middle !important;
	}
	</style>

{/literal}
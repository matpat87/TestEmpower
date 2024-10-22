<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

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


class CI_CustomerItemsViewEdit extends ViewEdit
{
 	public function __construct()
 	{
 		parent::__construct();
 		$this->useForSubpanel = true;
 		$this->useModuleQuickCreateTemplate = true;
 	}

 	function display(){
    
		if (! $this->bean->id) {
			$this->bean->product_master_non_db = 'TBD';
			$this->bean->product_number_c = 'TBD';
			$this->bean->version_c = '01';
		} else {
			$this->bean->product_master_non_db = "{$this->bean->product_number_c}.{$this->bean->version_c}";
		}

		// For Industry and Sub-Industry dropdown field customized values
		if (!empty($this->bean->sub_industry_c)) {
			$industryBean = BeanFactory::getBean('MKT_Markets', $this->bean->sub_industry_c);
			$this->bean->sub_industry_c =  $industryBean->sub_industry_c;
			$this->bean->industry_c =  $industryBean->id;

			if (!empty($this->bean->industry_c)) {
			}
		}
		
		// $jsScript = getVersionedScript('custom/modules/CI_CustomerItems/js/edit.js');
		$jsScript = "<script>
			$(document).ready(function(){
				var panel_bg_color = 'var(--custom-panel-bg)';
	
				$(\"div[field='marketing_information_non_db']\")
				.addClass('hidden')
				.prev()
				.removeClass('col-sm-2')
				.addClass('col-sm-12')
				.addClass('col-md-12')
				.addClass('col-lg-12')
				.css('background-color', panel_bg_color)
				.css('color', '#FFF')
				.css('margin-top', '15px')
				.css('padding', '0px 0px 8px 10px')
				.parent()
				.css('padding-left', '0px')
				.css('margin-top', '0px');

			});
		</script>";

		echo $jsScript;
		
		parent::display();

		// Handle dynamic versioning in JS file to prevent issues due to cache not reflecting changes
		$guid = create_guid();
        echo "<script type='text/javascript' src='custom/modules/CI_CustomerItems/js/edit.js?v={$guid}'></script>";
 	}

}
<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/TR_TechnicalRequests/TR_TechnicalRequests.php');
require_once('custom/modules/TR_TechnicalRequests/helper/TechnicalRequestHelper.php');

class TR_TechnicalRequestsUpdateDashlet extends DashletGeneric {
    function __construct($id, $def = null)
    {
        global $current_user, $app_strings;
        require('custom/modules/TR_TechnicalRequests/metadata/technicalrequestupdatedashletviewdefs.php');

        parent::__construct($id, $def);

        if (empty($def['title'])) {
            $this->title = translate('LBL_TECHNICAL_REQUEST_UPDATE', 'TR_TechnicalRequests');
        }

        $this->searchFields = $dashletData['TR_TechnicalRequestsUpdateDashlet']['searchFields'];
        $this->columns = $dashletData['TR_TechnicalRequestsUpdateDashlet']['columns'];

        $this->seedBean = new TR_TechnicalRequests();        
    }

    //Colormatch #314 - My TR Dashlet
    function process($lvsParams = array(), $id = null){
        global $log;

        //default sort order
        if(empty($lvsParams['orderBy'])){
            $lvsParams['orderBy'] = 'tr_update_date_c';
            $lvsParams['sortOrder'] = 'desc';
        }

        $_SESSION['dashlet'] = 'TR_TechnicalRequestsUpdateDashlet'; //#Colormatch #314 - for create_new_list_query distinction
        parent::process($lvsParams, $id);
    }

    function display(){
        global $log;

        $result = parent::display();
        $th_list_width = array(10, 16, 16, 16, 16, 16, 10);
        $result = TechnicalRequestHelper::manipulateDisplay($result, $th_list_width);
        return $result;
    }
}

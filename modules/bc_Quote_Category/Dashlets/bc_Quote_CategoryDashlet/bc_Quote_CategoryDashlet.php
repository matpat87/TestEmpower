<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/bc_Quote_Category/bc_Quote_Category.php');

class bc_Quote_CategoryDashlet extends DashletGeneric {

    function bc_Quote_CategoryDashlet($id, $def = null) {
        global $current_user, $app_strings;
        require('modules/bc_Quote_Category/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'bc_Quote_Category');

        $this->searchFields = $dashletData['bc_Quote_CategoryDashlet']['searchFields'];
        $this->columns = $dashletData['bc_Quote_CategoryDashlet']['columns'];

        $this->seedBean = new bc_Quote_Category();
    }

}

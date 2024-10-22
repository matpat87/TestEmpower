<?php

if (!defined('sugarEntry') || !sugarEntry)
    die('Not A Valid Entry Point');


require_once('include/Dashlets/DashletGeneric.php');
require_once('modules/bc_Quote/bc_Quote.php');

class bc_QuoteDashlet extends DashletGeneric {

    function bc_QuoteDashlet($id, $def = null) {
        global $current_user, $app_strings;
        require('modules/bc_Quote/metadata/dashletviewdefs.php');

        parent::DashletGeneric($id, $def);

        if (empty($def['title']))
            $this->title = translate('LBL_HOMEPAGE_TITLE', 'bc_Quote');

        $this->searchFields = $dashletData['bc_QuoteDashlet']['searchFields'];
        $this->columns = $dashletData['bc_QuoteDashlet']['columns'];

        $this->seedBean = new bc_Quote();
    }

}

<?php

class ListViewLogicHook {

    public function getURL(&$bean, $event, $arguments) {
        global $sugar_config;

        $record_bean = BeanFactory::getBean('RPT_CRMReports');
        $record_bean->retrieve($bean->id);
        $url = $sugar_config['site_url'] . '/index.php?module=' . $record_bean->module_url_c . '&action=index';

        $bean->name = '<a href="'. $url .'">' . $bean->name . '</a>';
    }
}

?>
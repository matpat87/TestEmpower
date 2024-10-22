<?php

class ListViewLogicHook {
    public function getURL(&$bean, $event, $arguments) {
        global $sugar_config;

        $recordBean = BeanFactory::getBean('MGMT_ManagementReports');
        $recordBean->retrieve($bean->id);
        $requestArray =  array(
            'searchFormTab' => 'basic_search',
            'query' => 'true',
            'orderBy' => '',
            'sortOrder' => '',
            'button' => 'Search'
        );

        $url = "{$sugar_config['site_url']}/index.php?action=index&module={$recordBean->module_url_c}";

        if (! empty($requestArray)) {
            $requestParams = http_build_query($requestArray);
            $url .= "&{$requestParams}";
        }

        $bean->name = "<a href='{$url}'>{$bean->name}</a>";
    }
}

?>
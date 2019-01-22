<?php

class ListViewLogicHook {

    public function getURL(&$bean, $event, $arguments) {
        global $sugar_config;

        $site_url = $sugar_config['site_url'];
        $record_bean = BeanFactory::getBean('MGMT_ManagementReports');
        $record_bean->retrieve($bean->id);
        $array_link = 'module=' . $record_bean->module_url_c;

    	//change URL if chromacolors
    	if(strpos($_SERVER['SERVER_NAME'], 'chromacolors') !== false)
    	{
    		$site_url = string_replace_all("carolinacolor", "chromacolors", $site_url);
    	}

        $url = $site_url . '/index.php?action=index&' . $array_link;

        $bean->name = '<a href="'. $url .'">' . $bean->name . '</a>';
    }
}

?>
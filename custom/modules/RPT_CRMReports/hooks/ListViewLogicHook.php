<?php

class ListViewLogicHook {

    public function getURL(&$bean, $event, $arguments) {
        global $sugar_config;

        $site_url = $sugar_config['site_url'];
        $record_bean = BeanFactory::getBean('RPT_CRMReports');
        $record_bean->retrieve($bean->id);
        $array_link = 'module=' . $record_bean->module_url_c;

	    if($record_bean->module_url_c == 'SAR_SalesActivityReport'){
	        $date_format = 'm/d/Y';
	        $date = new DateTime('now');
	        $date_7days = new DateTime($date->format($date_format));
	        $date_7days = $date_7days->add(new DateInterval('P7D'));
	        $request =  array('module' => 'SAR_SalesActivityReport',
	              'action' => 'index',
	              'searchFormTab' => 'basic_search',
	              'query' => 'true',
	              'orderBy' => '',
	              'sortOrder' => '',
	              'date_from_c_basic' => $date->format($date_format),
	              'date_to_c_basic' => $date_7days->format($date_format),
	              'button' => 'Search',);
	        $array_link = http_build_query($request);
    	}

    	//change URL if chromacolors
    	if(strpos($_SERVER['SERVER_NAME'], 'chromacolors') !== false)
    	{
    		$site_url = string_replace_all("carolinacolor", "chromacolors", $_SERVER['SERVER_NAME']);
    	}

        $url = $site_url . '/index.php?action=index&' . $array_link;

        $bean->name = '<a href="'. $url .'">' . $bean->name . '</a>';
    }
}

?>
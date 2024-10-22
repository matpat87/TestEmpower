<?php

class ListViewLogicHook {
    public function getURL(&$bean, $event, $arguments) {
        global $sugar_config;

        $recordBean = BeanFactory::getBean('RPT_CRMReports');
        $recordBean->retrieve($bean->id);
        $requestArray =  array(
            'searchFormTab' => 'basic_search',
            'query' => 'true',
            'orderBy' => '',
            'sortOrder' => '',
            'button' => 'Search'
        );

	    if ($recordBean->module_url_c == 'SAR_SalesActivityReport') {
            $datesArray = retrieveStartAndEndOfWeekDates();
            $requestArray['date_from_c_basic'] = $datesArray['startOfWeek'];
            $requestArray['date_to_c_basic'] = $datesArray['endOfWeek'];
    	} else if ($recordBean->module_url_c == 'AAR_AccountActivityReport') {
            $requestArray['custom_account_basic'] = [];
        } else if (in_array($recordBean->module_url_c, ['SVR_SalesViewReport', 'SRDO_SalesReportDailyOrders'])) {
            $requestArray = [];
        }

        $url = "{$sugar_config['site_url']}/index.php?action=index&module={$recordBean->module_url_c}";

        if (! empty($requestArray)) {
            $requestParams = http_build_query($requestArray);
            $url .= "&{$requestParams}";
        }

        $bean->name = "<a href='{$url}'>{$bean->name}</a>";
    }
}

?>
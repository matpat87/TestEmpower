<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=MKT_Markets&action=UpdateNameValues
updateNameValuesToIndustry();
function updateNameValuesToIndustry() {
	global $db, $app_list_strings, $log;

	$db = DBManagerFactory::getInstance();

    $marketsBean = BeanFactory::getBean('MKT_Markets')->get_full_list("", "", false, 0);
    $counter = 0;
    
    echo "Update Name values to Industry";
    foreach ($marketsBean as $market) {
       
        $sql = "UPDATE mkt_markets
        				LEFT JOIN mkt_markets_cstm
        					ON mkt_markets.id = mkt_markets_cstm.id_c
        				SET mkt_markets.name = '{$app_list_strings['industry_dom'][$market->industry]}' 
                        WHERE mkt_markets.id = '{$market->id}'";
    
        // $log->fatal(print_r($sql, true));
        echo "<pre>";
        echo $sql;
        echo "</pre>";
        $db->query($sql);
        $counter++;
    }

    echo "{$counter} Records Updated";


}
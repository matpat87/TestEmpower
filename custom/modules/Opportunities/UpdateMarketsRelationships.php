<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Opportunities&action=UpdateMarketsRelationships


updateMarketsRelationships();

function updateMarketsRelationships()
{
	global $db, $log;

    $opportunityBean = BeanFactory::getBean('Opportunities');
    $marketBeans = BeanFactory::getBean('MKT_NewMarkets');
    
    $sql = "SELECT 
                *
            FROM
                opportunities
                    LEFT JOIN
                opportunities_cstm ON opportunities_cstm.id_c = opportunities.id
                    AND opportunities.deleted = 0
            WHERE
                opportunities_cstm.market_c IS NOT NULL";
    $query = $db->query($sql);

    while ($row = $db->fetchByAssoc($query)) {
        $opportunityBean = BeanFactory::getBean('Opportunities', $row['id']);
       
        if (empty($opportunityBean->mkt_newmarkets_opportunities_1mkt_newmarkets_ida)) {
            $marketBean = BeanFactory::getBean('MKT_NewMarkets', $row['market_c']);
            $opportunityBean->load_relationship('mkt_newmarkets_opportunities_1');
            $opportunityBean->mkt_newmarkets_opportunities_1->add($marketBean);

            echo '<pre>';
            echo "Market C: {$row['market_c']} linked in Opp #{$row['oppid_c']}";
            echo '</pre>';
        }
    }
}



function addRelationshipToNewMaketsModule($opportunityBeans = [], $marketBean = [])
{
    global $log, $db;

    if (count($opportunityBeans) > 0 && count($marketBean) > 0) {
        
        foreach($opportunityBeans as $key => $bean) {
            $bean->load_relationship('mkt_newmarkets_opportunities_1');
            $bean->mkt_newmarkets_opportunities_1->add($marketBean[0]);
            // $bean->mkt_newmarkets_opportunities_1->add($marketBean[0]);
            // $log->fatal(print_r($marketBean->id, true));
        }
    }

    return true;
    
}
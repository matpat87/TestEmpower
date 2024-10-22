<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=CI_CustomerItems&action=UpdateIndustryValues


updateIndustryValues();

function updateIndustryValues()
{
	global $db, $log;

    $industryBeans = BeanFactory::getBean('MKT_Markets');
    $marketBeans = BeanFactory::getBean('MKT_NewMarkets');
    $customerProductsBeans = BeanFactory::getBean('CI_CustomerItems');

    $keywordsArray = array(
        'W&C' => 'Wire & Cable',
        'PIPE & CONDUIT' => 'Pipe & Conduit',
        'PIPE' => 'Pipe & Conduit',
        'PACKAGING' => 'Packaging',
        'MEDICAL' => 'Healthcare',
        'PHARMA' => 'Healthcare',
    );



    // Step 1: Update Old markets id and set it to the sub_industry_c and fill industry_c with values from its Industry Name (MKT_Markets `name`)
    $updateSubIndustrySQL = "UPDATE ci_customeritems_cstm
            INNER join ci_customeritems on ci_customeritems.id = ci_customeritems_cstm.id_c
            LEFT JOIN mkt_markets_ci_customeritems_1_c ON mkt_markets_ci_customeritems_1_c.mkt_markets_ci_customeritems_1ci_customeritems_idb = ci_customeritems.id
            LEFT JOIN mkt_markets ON mkt_markets.id = mkt_markets_ci_customeritems_1_c.mkt_markets_ci_customeritems_1mkt_markets_ida
        SET 
            sub_industry_c = mkt_markets_ci_customeritems_1_c.mkt_markets_ci_customeritems_1mkt_markets_ida,
            industry_c = mkt_markets.name
        WHERE mkt_markets_ci_customeritems_1_c.deleted = 0
    ";

    $db->query($updateSubIndustrySQL);
    echo '<pre>';
    echo $updateSubIndustrySQL;
    echo '</pre>';

    foreach ($keywordsArray as $key => $value) {
        // Step 1: Select every opportunity where their Sub-Industry begins with $key and set those records Market to $value.
        // [A] Get all id's of industries (mkt_markets) where name = "{$name}" 
        $industryBeansFiltered = $industryBeans->get_full_list('id',"LOWER(mkt_markets_cstm.sub_industry_c) LIKE LOWER('{$key}%')");
        $industryIdsArr = idImploder(array_column($industryBeansFiltered, 'id'));
        
        if ($industryIdsArr != '') {

            // [B] Update opportunities SET market_c = (select id of mkt_newmarkets where name is $value/marketname) where sub_industry_id IN [A] 
            $updateOpportunities = updateCustomerProductMarkets($value, $industryIdsArr); // UpdateSQL
           
            $nani = addRelationshipToNewMaketsModule(
                $customerProductsBeans->get_full_list('id'," ci_customeritems_cstm.sub_industry_c IN ({$industryIdsArr})"),
                $marketBeans->get_full_list('id',"LOWER(name) = LOWER('{$value}')")
            );
    
            echo '<pre>';
            echo "{$key}</br>";
            echo $updateOpportunities;
            echo '</pre>';
        }
    }
    
}

function idImploder($array = [])
{
    // Fetch keys of array then implode with comma while wrapping key values with quotes
    return isset($array) && is_array($array) ? implode(', ', array_map(function($string) {
        return "'{$string}'";
    }, $array)) : '';
}

function updateCustomerProductMarkets($keyword = '', $implodedIds = '')
{
    global $db, $log;
    

    $keyword = strtolower($keyword);

    $updateSQL = "UPDATE ci_customeritems_cstm
        LEFT JOIN ci_customeritems ON ci_customeritems.id = ci_customeritems_cstm.id_c
        SET
        ci_customeritems_cstm.new_market_c = (SELECT id FROM mkt_newmarkets WHERE LOWER(name) = '{$keyword}')
        WHERE ci_customeritems_cstm.sub_industry_c IN ({$implodedIds})
    ";
    
    $db->query($updateSQL); // execute query

    return $updateSQL;
}

function addRelationshipToNewMaketsModule($customerProductsBeans = [], $marketBean = [])
{
    global $log, $db;

    if (count($customerProductsBeans) > 0 && count($marketBean) > 0) {
        
        foreach($customerProductsBeans as $key => $bean) {
            $bean->load_relationship('mkt_newmarkets_ci_customeritems_1');
            $bean->mkt_newmarkets_ci_customeritems_1->add($marketBean[0]);
        }
    }

    return true;
    
}
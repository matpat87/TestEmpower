<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=CI_CustomerItems&action=MarketsCustomerItemsRelationship
relateMarketsCustomerItems();

function relateMarketsCustomerItems() {
    global $db;
    $db = DBManagerFactory::getInstance();

    $ciQueryString = "SELECT * FROM ci_customeritems_cstm WHERE mkt_markets_id_c IS NOT NULL";

    $customerItemsQry = $db->query($ciQueryString);
    $count = 0;
    while ($row = $db->fetchByAssoc($customerItemsQry)) {
        $newId = create_guid();
        $insertQry = "
        INSERT INTO `mkt_markets_ci_customeritems_1_c`
            (`id`,
            `date_modified`,
            `deleted`,
            `mkt_markets_ci_customeritems_1mkt_markets_ida`,
            `mkt_markets_ci_customeritems_1ci_customeritems_idb`)
        VALUES
            ('{$newId}',
            NOW(),
            0,
            '{$row["mkt_markets_id_c"]}',
            '{$row["id_c"] }');
        
        ";
        $db->query($insertQry);
        $count++;
    }

    echo $count . " Customer Item(s) have been inserted";
}
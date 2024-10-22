<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=PopulateM2MTechnicalRequestsAndProductMasterRelationship
populateM2MTechnicalRequestsAndProductMasterRelationship();

function populateM2MTechnicalRequestsAndProductMasterRelationship()
{
    global $db;

    $db = DBManagerFactory::getInstance();
    $sql = "SELECT * FROM tr_technicalrequests_aos_products_1_c WHERE deleted = 0";
    $result = $db->query($sql);

    while ($row = $db->fetchByAssoc($result) ) {
        $newID = create_guid();
        $date = gmdate('Y-m-d H:i:s');

        if (! checkIfRelationshipExists($row['tr_technicalrequests_aos_products_1tr_technicalrequests_ida'], $row['tr_technicalrequests_aos_products_1aos_products_idb'])) {
            $insertSQL = "  INSERT INTO tr_technicalrequests_aos_products_2_c (id, date_modified, deleted, tr_technicalrequests_aos_products_2tr_technicalrequests_ida, tr_technicalrequests_aos_products_2aos_products_idb)
                            VALUES ('{$newID}', '{$date}', 0, '{$row['tr_technicalrequests_aos_products_1tr_technicalrequests_ida']}', '{$row['tr_technicalrequests_aos_products_1aos_products_idb']}')";
            
            echo "{$insertSQL} <br>";
            $db->query($insertSQL);
        }
    }
}

function checkIfRelationshipExists($trID, $pmID)
{
    global $db;

    $query = "SELECT count(*) FROM tr_technicalrequests_aos_products_2_c WHERE tr_technicalrequests_aos_products_2tr_technicalrequests_ida = '{$trID}' AND tr_technicalrequests_aos_products_2aos_products_idb = '{$pmID}' AND deleted = 0";
    $result = $db->getOne($query);
    
    return ($result) ? true : false;
}
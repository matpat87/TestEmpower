<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Cases&action=UpdateInvoiceValues
updateInvoiceeValues();

function updateInvoiceeValues()
{
	global $db, $log;

    $selectSQL = "SELECT * FROM aos_invoices_cases_1_c";
    $result = $db->query($selectSQL);
    
    $count = 0;
    while($row = $db->fetchByAssoc($result)) {
        // array_push($array, $row['table_name']);
        $id = create_guid();

        $update = "INSERT INTO cases_aos_invoices_1_c (id, cases_aos_invoices_1cases_ida, cases_aos_invoices_1aos_invoices_idb)
            VALUES ('{$id}', '{$row["aos_invoices_cases_1cases_idb"]}', '{$row["aos_invoices_cases_1aos_invoices_ida"]}') ";

        $db->query($update);
        echo '<br>';
        echo $update;
        echo '<br>';
        $count++;
    }


    echo '<br>';
    echo "{$count} records inserted";
    echo '<br>';
    

}

<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;

// Call function in browser: <url>/index.php?module=Cases&action=PopulateClosedDate
populateClosedDate();

function populateClosedDate()
{
	global $db, $log;

    $customerIssueBean = BeanFactory::getBean('Cases');
    $beanList = $customerIssueBean->get_full_list('name',
        "cases.status = 'Closed' AND (cases_cstm.close_date_c IS NULL OR cases_cstm.close_date_c = '')"
        );
    
    foreach ($beanList as $bean) {
        $dateClosedSQL = $db->query("
            SELECT 
                date_created
            FROM
                suitecrm.cases_audit
            WHERE
                parent_id = '{$bean->id}'
                    AND field_name = 'status'
                    AND after_value_string = 'Closed'
            ORDER BY date_created DESC
            LIMIT 1
        ");

        $result = $db->fetchByAssoc($dateClosedSQL);
        if (!empty($result)) {
            $update = "
                UPDATE cases
                    LEFT JOIN
                cases_cstm ON cases_cstm.id_c = cases.id
                    AND cases.deleted = 0 
                SET 
                    cases_cstm.close_date_c = DATE('{$result['date_created']}')
                WHERE
                    cases.id = '{$bean->id}'
                ";
            
            $db->query($update);
                echo "<pre>";
                echo $update;
                echo "</pre>";

        }
    }
        
}

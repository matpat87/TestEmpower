<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');

// Call function in browser: <url>/index.php?module=TRI_TechnicalRequestItems&action=UpdateTRItemAssignments
updateTRItemAssignments();

function updateTRItemAssignments()
{
  global $db, $app_list_strings;

  $db = DBManagerFactory::getInstance();
  $sql = "SELECT tri_technicalrequestitems.id FROM tri_technicalrequestitems WHERE tri_technicalrequestitems.deleted = 0 AND tri_technicalrequestitems.status NOT IN ('complete', 'rejected')";
  $result = $db->query($sql);
  
  while ($row = $db->fetchByAssoc($result) ) {
    $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems', $row['id']);

    if (! $trItemBean->id) {
      continue;
    }

    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trItemBean->tri_techni0387equests_ida);
    
    if (! $trBean->id) {
      continue;
    }

    $assignedUserBean = TechnicalRequestItemsHelper::retrieveTRItemAssignedUser($trBean, $trItemBean->name);

    if (! $assignedUserBean->id) {
      continue;
    }

    if ($trItemBean->assigned_user_id != $assignedUserBean->id) {
      $updateQuery = "UPDATE tri_technicalrequestitems SET tri_technicalrequestitems.assigned_user_id = '{$assignedUserBean->id}' WHERE tri_technicalrequestitems.id = '{$trItemBean->id}'";
      $db->query($updateQuery);

      echo '<pre>';
        print_r($updateQuery);
        echo '<br>';
      echo '</pre>';
    }
  }
}
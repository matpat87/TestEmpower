<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/TRWG_TRWorkingGroup/helpers/TRWorkingGroupHelper.php');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=UpdateTRAwaitingTargetResinWorkgroupsAndAssignments
updateTRAwaitingTargetResinWorkgroupsAndAssignments();

function updateTRAwaitingTargetResinWorkgroupsAndAssignments()
{
  global $db;

  $db = DBManagerFactory::getInstance();
  $sql = "SELECT tr_technicalrequests.id FROM tr_technicalrequests WHERE tr_technicalrequests.deleted = 0 AND tr_technicalrequests.approval_stage = 'development' AND tr_technicalrequests.status = 'awaiting_target_resin' ORDER BY tr_technicalrequests.name ASC";
  $result = $db->query($sql);

  $_REQUEST['skip_hook'] = true;

  while ($row = $db->fetchByAssoc($result)) {
    $trBean = BeanFactory::getBean('TR_TechnicalRequests', $row['id']);

    if ($trBean && $trBean->id) {      
      TRWorkingGroupHelper::createOrUpdateTRRole($trBean, 'RDManager');
      
      $workGroupSiteRDManagerList = $trBean->get_linked_beans('tr_technicalrequests_trwg_trworkinggroup_1', 'TRWG_TRWorkingGroup', array(), 0, -1, 0, "trwg_trworkinggroup.tr_roles = 'RDManager' AND trwg_trworkinggroup.parent_type = 'Users'");
      $siteRDManagerBean = (!empty($workGroupSiteRDManagerList) && count($workGroupSiteRDManagerList) > 0) ? BeanFactory::getBean('Users', $workGroupSiteRDManagerList[0]->parent_id) : null;

      if ($siteRDManagerBean && $siteRDManagerBean->id) {
        echo "<br>";
        echo "TR Record ID: {$trBean->id}";
        echo "<br>";
        echo "TR Stage: {$trBean->approval_stage}";
        echo "<br>";
        echo "TR Status: {$trBean->status}";
        echo "<br>";
        echo "TR Current Assigned User ID: {$trBean->assigned_user_id}";
        echo "<br>";
        echo "R&D Manager ID: {$siteRDManagerBean->id}";
        echo "<br>";
        echo "R&D Manager Name: {$siteRDManagerBean->name}";
        echo "<br>";

        $trBean->assigned_user_id = $siteRDManagerBean->id;
        $updateQuery = "UPDATE tr_technicalrequests SET assigned_user_id = '{$siteRDManagerBean->id}' WHERE id = '{$trBean->id}'";
        $db->query($updateQuery);
      }
    }
  }
}
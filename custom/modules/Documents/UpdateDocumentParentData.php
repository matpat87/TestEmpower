<?php
require_once('custom/modules/CWG_CAPAWorkingGroup/helpers/CapaWorkingGroupHelper.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Documents&action=UpdateDocumentParentData
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Populate Document Parent ID and Parent Type based on Relationship that has Data - Job";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::UpdateDocumentParentDataJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
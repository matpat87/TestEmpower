<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=RRQ_RegulatoryRequests&action=UpdateRegulatoryRequestAccountAssignments
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Update Regulatory Request Account Assignments To Parent Account";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::UpdateRegulatoryRequestAccountAssignmentsJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Accounts&action=ResetAndReassignSecurityGroupsAndAssignments
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Reset And Reassign Security Groups And Assignments Scheduler";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::ResetAndReassignSecurityGroupsAndAssignmentsJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
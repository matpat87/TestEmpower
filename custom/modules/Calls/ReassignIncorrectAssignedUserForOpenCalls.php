<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Calls&action=ReassignIncorrectAssignedUserForOpenCalls
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Reassign Incorrect Assigned User For Open Calls Job";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::ReassignIncorrectAssignedUserForOpenCallsJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
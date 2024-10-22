<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=TR_TechnicalRequests&action=UpdateTrStatusOnDevComplete
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Update TR with type Product Chips/Product Sample to Closed";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::UpdateTrStatusOnDevCompleteJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
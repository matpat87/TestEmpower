<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=TRI_TechnicalRequestItems&action=UpdateTRItemProductNumber
updateTRItemProductNumber();

function updateTRItemProductNumber()
{
  global $current_user;

  $scheduledJob = new SchedulersJob();
  $scheduledJob->name = "Update TR Item Product Number Job";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::UpdateTRItemProductNumberJob";
  $scheduledJob->requeue = true;
  $scheduledJob->retry_count = 5;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
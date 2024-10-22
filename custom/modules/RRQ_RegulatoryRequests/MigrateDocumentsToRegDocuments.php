<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// require('include/UploadFile.php');

// Call function in browser: <url>/index.php?module=RRQ_RegulatoryRequests&action=MigrateDocumentsToRegDocuments
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Migrate Regulatory Request-related Documents to Regulatory Documents";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::MigrateDocumentsToRegDocumentsJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
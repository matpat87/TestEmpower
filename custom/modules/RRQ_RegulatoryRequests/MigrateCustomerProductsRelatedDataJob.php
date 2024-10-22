<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=RRQ_RegulatoryRequests&action=MigrateCustomerProductsRelatedDataJob
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Migrate reationship rows between Regulatory Requests and Customer Products to new many-to-many link table";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::MigrateCustomerProductsRelatedDataJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);

  echo "<pre>";
  echo "Executing MigrateCustomerProductsRelatedDataJob Job Queue";
  echo "</pre>";
}
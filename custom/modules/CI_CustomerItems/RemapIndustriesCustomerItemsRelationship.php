<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=CI_CustomerItems&action=RemapIndustriesCustomerItemsRelationship
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Remap Industries and Customer Items Relationship Job";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::RemapIndustriesCustomerItemsRelationshipJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
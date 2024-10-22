<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Opportunities&action=OpportunityTriggerCalculateProbabilityScheduler
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Opportunity Trigger Calculate Probability Scheduler Job";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::OpportunityTriggerCalculateProbabilitySchedulerJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=MKT_Markets&action=RemapIndustryToRelatedModules
initiateJobQueue();

function initiateJobQueue()
{
    global $current_user;

    require_once 'include/SugarQueue/SugarJobQueue.php';
    $scheduledJob = new SchedulersJob();
  
    $scheduledJob->name = "Remap Industries to Opportunities & Customer Products Relationship Job";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::RemapIndustryToRelatedModulesJob";
  
    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);
    
}
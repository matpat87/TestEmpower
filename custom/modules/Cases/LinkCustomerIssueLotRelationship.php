<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Cases&action=LinkCustomerIssueLotRelationship

initiateJobQueue();

function initiateJobQueue()
{
    global $current_user;
    
    require_once 'include/SugarQueue/SugarJobQueue.php';
    $scheduledJob = new SchedulersJob();

    $scheduledJob->name = "Link Customer Issue Lot Relationship Scheduler Job";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::LinkCustomerIssueLotRelationshipSchedulerJob";

    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);
}
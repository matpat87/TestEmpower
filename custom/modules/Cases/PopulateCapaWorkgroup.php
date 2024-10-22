<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Cases&action=PopulateCapaWorkgroup

initiateJobQueue();

function initiateJobQueue()
{
    global $current_user;
    
    require_once 'include/SugarQueue/SugarJobQueue.php';
    $scheduledJob = new SchedulersJob();

    $scheduledJob->name = "Populate CAPA Workgroup Scheduler Job";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::PopulateCAPAWorkgroupSchedulerJob";

    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);
}
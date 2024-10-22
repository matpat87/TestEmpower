<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
  
// Call function in browser: <url>/index.php?module=Accounts&action=UpdateAccountOEM
initiateJobQueue();

function initiateJobQueue()
{
    global $current_user;
    
    require_once 'include/SugarQueue/SugarJobQueue.php';
    $scheduledJob = new SchedulersJob();

    $scheduledJob->name = "Update Account OEM Scheduler";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::UpdateAccountOEMJob";

    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);
}
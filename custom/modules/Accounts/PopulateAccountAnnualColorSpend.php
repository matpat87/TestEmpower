<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
  
// Call function in browser: <url>/index.php?module=Accounts&action=PopulateAccountAnnualColorSpend
initiateJobQueue();

function initiateJobQueue()
{
    global $current_user;
    
    require_once 'include/SugarQueue/SugarJobQueue.php';
    $scheduledJob = new SchedulersJob();

    $scheduledJob->name = "Populate Account Annual Color Spend Scheduler";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::PopulateAccountAnnualColorSpendJob";

    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);
}
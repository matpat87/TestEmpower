<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
  
// Call function in browser: <url>/index.php?module=AOS_Invoices&action=UpdateOrderNumberFieldFromRecordIdToOrderNumber
initiateJobQueue();

function initiateJobQueue()
{
    global $current_user;
    
    require_once 'include/SugarQueue/SugarJobQueue.php';
    $scheduledJob = new SchedulersJob();

    $scheduledJob->name = "Update Order Number Field From Record Id To Order Number Job";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::UpdateOrderNumberFieldFromRecordIdToOrderNumberJob";

    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);
}
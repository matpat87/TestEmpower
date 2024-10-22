<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=AOS_Products&action=PopulateProductMasterMissingGeometry
initiateJobQueue();

function initiateJobQueue()
{
    global $current_user;

    require_once 'include/SugarQueue/SugarJobQueue.php';
    $scheduledJob = new SchedulersJob();

    $scheduledJob->name = "Populate Product Master Missing Geometry";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::PopulateProductMasterMissingGeometryJob";

    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);
}
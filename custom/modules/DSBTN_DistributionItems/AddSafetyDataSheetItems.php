<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=DSBTN_DistributionItems&action=AddSafetyDataSheetItems
initiateJobQueue();

function initiateJobQueue()
{
	global $current_user;

	require_once 'include/SugarQueue/SugarJobQueue.php';
	$scheduledJob = new SchedulersJob();

	$scheduledJob->name = "Add Safety Data Sheet Distro Item";
	$scheduledJob->assigned_user_id = $current_user->id;
	$scheduledJob->target = "class::AddSafetyDataSheetItemsJob";

	$queue = new SugarJobQueue();
	$queue->submitJob($scheduledJob);
}
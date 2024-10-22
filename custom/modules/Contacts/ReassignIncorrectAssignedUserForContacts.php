<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=Contacts&action=ReassignIncorrectAssignedUserForContacts
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user;

  require_once 'include/SugarQueue/SugarJobQueue.php';
  $scheduledJob = new SchedulersJob();

  $scheduledJob->name = "Reassign Incorrect Assigned User For Contacts Job";
  $scheduledJob->assigned_user_id = $current_user->id;
  $scheduledJob->target = "class::ReassignIncorrectAssignedUserForContactsJob";

  $queue = new SugarJobQueue();
  $queue->submitJob($scheduledJob);
}
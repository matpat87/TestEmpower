<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;
  
// Call function in browser: <url>/index.php?module=Accounts&action=ResetAndReassignSecurityGroups
initiateJobQueue();

function initiateJobQueue()
{
  global $current_user, $timedate;

  $offset = 0;
  $limit = 2000;
  $executeTime = $timedate->nowDb();

  $numberOfAccounts = retrieveNumberOfAccounts();
  $numberOfJobs = $numberOfAccounts ? ceil($numberOfAccounts / $limit) : 0;

  if (! $numberOfJobs) {
    return;
  }

  require_once 'include/SugarQueue/SugarJobQueue.php';

  for ($ctr = 1; $ctr <= $numberOfJobs; $ctr++) { 
    $scheduledJob = new SchedulersJob();
    $scheduledJob->name = "Reset And Reassign Security Groups Scheduler - {$ctr} (Limit: {$limit}, Offset: {$offset})";
    $scheduledJob->assigned_user_id = $current_user->id;
    $scheduledJob->target = "class::ResetAndReassignSecurityGroupsJob";
    $scheduledJob->execute_time = $executeTime;
    $scheduledJob->requeue = true;
    $scheduledJob->retry_count = 5;
    $scheduledJob->data = json_encode([
      'counter' => $ctr,
      'limit' => $limit,
      'offset' => $offset
    ]);

    $queue = new SugarJobQueue();
    $queue->submitJob($scheduledJob);

    $offset = $offset + $limit;
    $executeTime = Carbon::parse($executeTime)->addHours(2);
  }
}

function retrieveNumberOfAccounts()
{
  global $db;

  $query = "SELECT COUNT(*) FROM accounts WHERE deleted = 0";
  $result = $db->getOne($query);
		
  return $result;
}
<?php
    
	$job_strings[] = 'runElasticSearchFullIndexingScheduler';

	function runElasticSearchFullIndexingScheduler()
	{
		global $db, $app_list_strings;
		
		// Get the current time in UTC
		$utcNow = \Carbon\Carbon::now('UTC');
		
		// Convert to Central Standard Time (CST)
		$cstNow = $utcNow->tz('America/Chicago');
		$GLOBALS['log']->fatal("Run Elastic Search Full Indexing Scheduler - START");

		// Originally 6:00 AM (CST) but we will run it at 7:30 AM (CST)
		$onTheHour = \Carbon\Carbon::create(null, null, null, 7, 30, 0, 'America/Chicago');
		// Originally 7:00 AM (CST) but end time will be 8:30 AM (CST)
		$endHour = \Carbon\Carbon::create(null, null, null, 8, 30, 0, 'America/Chicago');
		

		// Originally between 6AM - 7AM (CST), but is updated to 7:30AM - 8:30AM (CST)
		if ($cstNow->between($onTheHour, $endHour)) {
			$formatTimeNow = $cstNow->format('Y-m-d H:i:s');

			$GLOBALS['log']->fatal("Elastic Search Full Indexing ran Scheduled Job - STARTS at {$formatTimeNow}");
			$job = new SchedulersJob();
	
			$job->name = 'Index requested by an administrator';
			$job->target = 'function::runElasticSearchIndexerScheduler';
			$job->data = json_encode(['partial' => false]); // False when running full indexing Reference: modules/Administration/Search/ElasticSearch/Controller.php :: doFullIndex()
			$job->assigned_user_id = 1;
	
			$queue = new SugarJobQueue();
			/** @noinspection PhpParamsInspection */
			$queue->submitJob($job);
	
			$GLOBALS['log']->fatal("Elastic Search Full Indexing ran Scheduled Job");

		} else {
			$GLOBALS['log']->fatal("Elastic Search Full Indexing not yet running.");
		}
		

		$GLOBALS['log']->fatal("Run ElasticSearch Full Indexing Scheduler - END");
		return true;
	}
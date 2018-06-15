<?php

$manifest = array (
	'built_in_version' => '7.5.0.0',
    'acceptable_sugar_versions' => 
     array (
     	0 => '',
     ),
	 'acceptable_sugar_flavors' =>
     array(
        'CE', 'PRO', 'ENT', 'CORP', 'ULT'
	 ),
	 'readme'=> '',
	 'key'=> 'asol',
	 'author' => 'AlineaSol',
	 'description' => 'You do not need to uninstall previous WFM version. Please, see README.txt',
	 'icon' => '',
	 'is_uninstallable' => true,
	 'name' => 'AlineaSol WorkFlowManager - Community Edition',
	 'published_date' => '2017-02-22',
	 'type' => 'module',
	 'version' => '5.16.1',
	 'remove_tables' => 'prompt',
);
          
$installdefs = array (
  'id' => 'AlineaSolWorkFlowManager',
  'beans' => 
  array (
    0 => 
    array (
      'module' => 'asol_Activity',
      'class' => 'asol_Activity',
      'path' => 'modules/asol_Activity/asol_Activity.php',
      'tab' => false,
    ),
    1 => 
    array (
      'module' => 'asol_Events',
      'class' => 'asol_Events',
      'path' => 'modules/asol_Events/asol_Events.php',
      'tab' => false,
    ),
	  2 => 
    array (
      'module' => 'asol_OnHold',
      'class' => 'asol_OnHold',
      'path' => 'modules/asol_OnHold/asol_OnHold.php',
      'tab' => false,
    ),
    3 => 
    array (
      'module' => 'asol_Process',
      'class' => 'asol_Process',
      'path' => 'modules/asol_Process/asol_Process.php',
      'tab' => true,
    ),
  4 => 
    array (
      'module' => 'asol_ProcessInstances',
      'class' => 'asol_ProcessInstances',
      'path' => 'modules/asol_ProcessInstances/asol_ProcessInstances.php',
      'tab' => false,
    ),
    5 => 
    array (
      'module' => 'asol_Task',
      'class' => 'asol_Task',
      'path' => 'modules/asol_Task/asol_Task.php',
      'tab' => false,
    ),
   6 => 
    array (
      'module' => 'asol_WorkingNodes',
      'class' => 'asol_WorkingNodes',
      'path' => 'modules/asol_WorkingNodes/asol_WorkingNodes.php',
      'tab' => false,
    ),
    7 => 
    array (
      'module' => 'asol_WorkFlowManagerCommon',
      'class' => 'asol_WorkFlowManagerCommon',
      'path' => 'modules/asol_WorkFlowManagerCommon/asol_WorkFlowManagerCommon.php',
      'tab' => false,
    ),
  ),
  'layoutdefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_events_asol_activity_asol_Events.php',
      'to_module' => 'asol_Events',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_process_asol_events_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_activity_asol_activity_asol_Activity.php',
      'to_module' => 'asol_Activity',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_activity_asol_task_asol_Activity.php',
      'to_module' => 'asol_Activity',
    ),
     4 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_events_asol_activity_asol_Activity.php',
      'to_module' => 'asol_Activity',
    ),
    7 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_process_asol_events_1_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
    8 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_process_asol_activity_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
    9 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/layoutdefs/asol_process_asol_task_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
    
  ),
  'relationships' => 
  array (
    0 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/asol_events_asol_activityMetaData.php',
    ),
    1 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/asol_process_asol_eventsMetaData.php',
    ),
    2 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/asol_activity_asol_activityMetaData.php',
    ),
    3 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/asol_activity_asol_taskMetaData.php',
    ),
    5 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/asol_process_asol_events_1MetaData.php',
    ),
    6 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/asol_process_asol_activityMetaData.php',
    ),
    7 => 
    array (
      'meta_data' => '<basepath>/SugarModules/relationships/relationships/asol_process_asol_taskMetaData.php',
    ),
    
  ),
  'image_dir' => '<basepath>/icons',
  'copy' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_Activity',
      'to' => 'modules/asol_Activity',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_Events',
      'to' => 'modules/asol_Events',
    ),
	2 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_OnHold',
      'to' => 'modules/asol_OnHold',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_Process',
      'to' => 'modules/asol_Process',
    ),
	4 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_ProcessInstances',
      'to' => 'modules/asol_ProcessInstances',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_Task',
      'to' => 'modules/asol_Task',
    ),
	6 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_WorkingNodes',
      'to' => 'modules/asol_WorkingNodes',
    ),
    7 => 
    array (
      'from' => '<basepath>/custom',
      'to' => 'custom',
    ),
    8 => 
    array (
      'from' => '<basepath>/include/generic/SugarWidgets',
      'to' => 'include/generic/SugarWidgets',
    ),
    9 => 
    array (
      'from' => '<basepath>/SugarModules/modules/asol_WorkFlowManagerCommon',
      'to' => 'modules/asol_WorkFlowManagerCommon',
    ),
    
  ),
  'language' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/en_us.asol_Activity.php',
      'to_module' => 'asol_Activity',
      'language' => 'en_us',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/en_us.asol_Events.php',
      'to_module' => 'asol_Events',
      'language' => 'en_us',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/en_us.asol_Process.php',
      'to_module' => 'asol_Process',
      'language' => 'en_us',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/en_us.asol_Task.php',
      'to_module' => 'asol_Task',
      'language' => 'en_us',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/en_us.AlineaSolWFM.php',
      'to_module' => 'application',
      'language' => 'en_us',
    ),
    5 =>
	array(
	  'from' => '<basepath>/language/en_us.administration.php' ,
	  'to_module' => 'Administration' ,
	  'language' => 'en_us',
	) ,
	
	
	
	10 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/sp_ve.asol_Activity.php',
      'to_module' => 'asol_Activity',
      'language' => 'sp_ve',
    ),
   	11 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/sp_ve.asol_Events.php',
      'to_module' => 'asol_Events',
      'language' => 'sp_ve',
    ),
    12 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/sp_ve.asol_Process.php',
      'to_module' => 'asol_Process',
      'language' => 'sp_ve',
    ),
    13 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/sp_ve.asol_Task.php',
      'to_module' => 'asol_Task',
      'language' => 'sp_ve',
    ),
    14 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/sp_ve.AlineaSolWFM.php',
      'to_module' => 'application',
      'language' => 'sp_ve',
    ),
    15 =>
	array(
	  'from' => '<basepath>/language/sp_ve.administration.php' ,
	  'to_module' => 'Administration' ,
	  'language' => 'sp_ve',
	) ,
	
	
	
	20 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/fr_FR.asol_Activity.php',
      'to_module' => 'asol_Activity',
      'language' => 'fr_FR',
    ),
   	21 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/fr_FR.asol_Events.php',
      'to_module' => 'asol_Events',
      'language' => 'fr_FR',
    ),
    22 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/fr_FR.asol_Process.php',
      'to_module' => 'asol_Process',
      'language' => 'fr_FR',
    ),
    23 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/language/fr_FR.asol_Task.php',
      'to_module' => 'asol_Task',
      'language' => 'fr_FR',
    ),
    24 => 
    array (
      'from' => '<basepath>/SugarModules/language/application/fr_FR.AlineaSolWFM.php',
      'to_module' => 'application',
      'language' => 'fr_FR',
    ),
    25 =>
	array(
	  'from' => '<basepath>/language/fr_FR.administration.php' ,
	  'to_module' => 'Administration' ,
	  'language' => 'fr_FR',
	) ,
  ),
  'vardefs' => 
  array (
    0 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_events_asol_activity_asol_Activity.php',
      'to_module' => 'asol_Activity',
    ),
    1 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_events_asol_activity_asol_Events.php',
      'to_module' => 'asol_Events',
    ),
    2 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_events_asol_Events.php',
      'to_module' => 'asol_Events',
    ),
    3 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_events_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
    4 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_activity_asol_activity_asol_Activity.php',
      'to_module' => 'asol_Activity',
    ),
    5 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_activity_asol_task_asol_Activity.php',
      'to_module' => 'asol_Activity',
    ),
    6 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_activity_asol_task_asol_Task.php',
      'to_module' => 'asol_Task',
    ),
    9 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_events_1_asol_Events.php',
      'to_module' => 'asol_Events',
    ),
    10 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_events_1_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
    11 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_activity_asol_Activity.php',
      'to_module' => 'asol_Activity',
    ),
    12 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_activity_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
    13 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_task_asol_Task.php',
      'to_module' => 'asol_Task',
    ),
    14 => 
    array (
      'from' => '<basepath>/SugarModules/relationships/vardefs/asol_process_asol_task_asol_Process.php',
      'to_module' => 'asol_Process',
    ),
  ),
  'layoutfields' => 
  array (
    0 => 
    array (
      'additional_fields' => 
      array (
      ),
    ),
    1 => 
    array (
      'additional_fields' => 
      array (
      ),
    ),
    2 => 
    array (
      'additional_fields' => 
      array (
      ),
    ),
  ),
  
  'pre_execute'=>array(
    0 => '<basepath>/actions/pre_install.php',
  ),
  
  'post_execute'=>array(
	0 => '<basepath>/actions/post_install.php',
   ),
	
  'post_uninstall'=>array(
	0 => '<basepath>/actions/post_uninstall.php',
  ),
  
);
<?php 
    handleVerifyBeforeRequire('custom/modules/MDM_ModuleManagement/ModuleManagementDataSchedulerJob.php');

    $job_strings[] = 'handleCreateNewModulesScheduler';

  function handleCreateNewModulesScheduler() {
    
    $GLOBALS['log']->fatal("Handle Create new modules in MODULE MANAGEMENT - START");

    $moduleManagementData = new ModuleManagementData();
	$moduleManagementData->process();

    $GLOBALS['log']->fatal("Handle Create new modules in MODULE MANAGEMENT - END");
    
    return true;
    
}
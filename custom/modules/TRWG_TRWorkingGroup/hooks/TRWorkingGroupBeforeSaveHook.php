<?php
    require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');
    require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');

	class TRWorkingGroupBeforeSaveHook
    {
		public function handleDuplicateRole(&$bean, $event, $arguments)
		{
            if (((isset($_REQUEST['skip_hook']) && $_REQUEST['skip_hook'])) || $_REQUEST['massupdate']) {
                return true;
            }

            $trId = $bean->tr_technic9742equests_ida;

            if ($_REQUEST['return_module'] == 'TR_TechnicalRequests') {
                $trId = $_REQUEST['tr_technic9742equests_ida'];
            }

            $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trId);

            if ($trBean->id && $bean->tr_roles != 'Other') {
                $trBean->load_relationship('tr_technicalrequests_trwg_trworkinggroup_1');

				$trWorkgroupBeanList = $trBean->get_linked_beans(
					'tr_technicalrequests_trwg_trworkinggroup_1',
					'TRWG_TRWorkingGroup',
					array(),
					0,
					-1,
					0,
					"trwg_trworkinggroup.tr_roles = '{$bean->tr_roles}'"
				);

                if ($trWorkgroupBeanList != null && count($trWorkgroupBeanList) > 0) {
                    $trWorkGroupBean = $trWorkgroupBeanList[0];

                    // Need to retrieve TR Work Group bean again to not cause issues on save
                    $workGroupBean = BeanFactory::getBean('TRWG_TRWorkingGroup', $trWorkGroupBean->id);
                    $workGroupBean->parent_id = $bean->parent_id;
                    $workGroupBean->parent_type = $bean->parent_type;
                    $workGroupBean->save();

                    // Note: Many modules calls the TechnicalRequestItemsHelper::handleTRItemsCRUDWorkflow function
                    // Only execute if Save was triggered directly from this module (TRWG_TRWorkingGroup)
                    // To prevent instances where it loops due to overlapping hooks
                    if ($_REQUEST['module'] === 'TRWG_TRWorkingGroup') {
                        TechnicalRequestItemsHelper::handleTRItemsCRUDWorkflow($trBean);
                    }

                    // If Colormatch Coordinator Workgroup Member is changed, update Distro Item assignment (Not Complete or Rejected)
                    if ($bean->tr_roles == 'ColorMatchCoordinator') {
                        $prevColormatchCoordinatorBean = BeanFactory::getBean('Users', $bean->fetched_row['parent_id']);
                        DistributionHelper::handleColormatchCoordinatorDistroItemsReassignment($trBean, $prevColormatchCoordinatorBean);
                    }
                    
                    if (! $_REQUEST['return_module'] || (isset($_REQUEST['skip_redirect']) && $_REQUEST['skip_redirect'])) {
                        return true;
                    }

                    $returnModule = $_REQUEST['return_module'];
                    $returnId = $_REQUEST['return_module'] != 'TRWG_TRWorkingGroup' ? $_REQUEST['return_id'] : $workGroupBean->id;

                    $params = [
                        'module'=> $returnModule,
                        'action'=>'DetailView', 
                        'record' => $returnId
                    ];
        
                    // To prevent logic hook from proceeding and creating the record, redirect to the return module's detailview page
                    // This is to prevent duplicate TR Workgroup from being created
                    SugarApplication::redirect('index.php?' . http_build_query($params));
                }
            }
            
        }
	}
?>
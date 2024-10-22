<?php
	class RRWorkingGroupBeforeSaveHook
    {
		public function handleDuplicateRole(&$bean, $event, $arguments)
		{
            if (((isset($_REQUEST['skip_hook']) && $_REQUEST['skip_hook'])) || $_REQUEST['massupdate']) {
                return true;
            }

            $rrId = $bean->rrq_regula2443equests_ida;

            if ($_REQUEST['return_module'] == 'RRQ_RegulatoryRequests') {
                $rrId = $_REQUEST['rrq_regula2443equests_ida'];
            }

            $rrBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $rrId);

            if ($rrBean->id) {
                $rrBean->load_relationship('rrq_regulatoryrequests_rrwg_rrworkinggroup_1');

				$rrWorkgroupBeanList = $rrBean->get_linked_beans(
					'rrq_regulatoryrequests_rrwg_rrworkinggroup_1',
					'RRWG_RRWorkingGroup',
					array(),
					0,
					-1,
					0,
					"rrwg_rrworkinggroup.rr_roles = '{$bean->rr_roles}'"
				);

                if ($rrWorkgroupBeanList != null && count($rrWorkgroupBeanList) > 0) {
                    $rrWorkGroupBean = $rrWorkgroupBeanList[0];

                    // Need to retrieve RR Work Group bean again to not cause issues on save
                    $workGroupBean = BeanFactory::getBean('RRWG_RRWorkingGroup', $rrWorkGroupBean->id);
                    $workGroupBean->parent_id = $bean->parent_id;
                    $workGroupBean->parent_type = $bean->parent_type;
                    $workGroupBean->save();
                    
                    if (! $_REQUEST['return_module'] || (isset($_REQUEST['skip_redirect']) && $_REQUEST['skip_redirect'])) {
                        return true;
                    }

                    $returnModule = $_REQUEST['return_module'];
                    $returnId = $_REQUEST['return_module'] != 'RRWG_RRWorkingGroup' ? $_REQUEST['return_id'] : $workGroupBean->id;

                    $params = [
                        'module'=> $returnModule,
                        'action'=>'DetailView', 
                        'record' => $returnId
                    ];
        
                    // To prevent logic hook from proceeding and creating the record, redirect to the return module's detailview page
                    // This is to prevent duplicate RR Workgroup from being created
                    SugarApplication::redirect('index.php?' . http_build_query($params));
                }
            }
            
        }
	}
?>
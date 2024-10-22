<?php
  require_once('custom/modules/TRI_TechnicalRequestItems/helper/TechnicalRequestItemsHelper.php');
  require_once('custom/modules/DSBTN_Distribution/helper/DistributionHelper.php');

  class TechnicalRequestItemsAfterSaveHook
  {
    public function handleCompletedTrItemNotification(&$bean, $event, $arguments)
    {
      global $current_user, $sugar_config, $app_list_strings, $log;
      $triLink = "{$sugar_config['site_url']}/index.php?module=TRI_TechnicalRequestItems&action=DetailView&record={$bean->id}";
      $customBody = "Technical Request Item";

      if ($bean->fetched_row['status'] != $bean->status && $bean->status == 'complete') {
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tri_techni0387equests_ida);
        $recipientsArray = [];

        if ($trBean && $trBean->id) {
          $trAssignedUserBean = BeanFactory::getBean('Users', $trBean->assigned_user_id);
          ($trAssignedUserBean && $trAssignedUserBean->id) ? array_push($recipientsArray, $trAssignedUserBean) : '';
          
          if ($bean->name == 'quote') {
            
            $triLink = "{$sugar_config['site_url']}/index.php?module=TR_TechnicalRequests&action=DetailView&record={$trBean->id}";
            $customBody = "Technical Request";
            // $triDocumentRow = TechnicalRequestItemsHelper::retrieveTriDocument($bean); -- Depracated: changed Link to parent TR Retrieve the TR Item Document (Quote)
            
            // if (!empty($triDocumentRow)) {

            // }
            
            $distroBean = BeanFactory::getBean('DSBTN_Distribution');
            $distroBeanList = $distroBean->get_full_list("", "dsbtn_distribution_cstm.tr_technicalrequests_id_c = '{$trBean->id}'", false, 0);

            if ($distroBeanList != null && count($distroBeanList) > 0) {
              foreach ($distroBeanList as $distroBean) {
                $distroItemBean = BeanFactory::getBean('DSBTN_DistributionItems');
                $distroItemBeanList = $distroItemBean->get_full_list("", "dsbtn_distributionitems_cstm.dsbtn_distribution_id_c = '{$distroBean->id}' AND dsbtn_distributionitems_cstm.distribution_item_c = 'quote'", false, 0);

                if (isset($distroItemBeanList) && !empty($distroItemBeanList)) {
                  foreach($distroItemBeanList as $distroItemBean) {
                    if ($distroItemBean->assigned_user_id) {
                      $distroItemAssignedUserBean = BeanFactory::getBean('Users', $distroItemBean->assigned_user_id);
                      ($distroItemAssignedUserBean->id != $trAssignedUserBean->id) ? array_push($recipientsArray, $distroItemAssignedUserBean) : '';
                    }
                  }
                }
              }
            }
          }
          
          if ($recipientsArray != null && count($recipientsArray) > 0) {
            $emailObj = new Email();
            $defaults = $emailObj->getSystemDefaultEmail();
                        
            $trItemName = $app_list_strings['distro_item_list'][$bean->name];

            $mail = new SugarPHPMailer();
            $mail->setMailerForSystem();
            $mail->From = $defaults['email'];
            $mail->FromName = $defaults['name'];
            $mail->Subject = "EmpowerCRM Completed Technical Request #{$trBean->technicalrequests_number_c} - Item {$trItemName}";

            $customQABanner = $sugar_config['isQA'] == true ? '<span style="color: red;">***This is a test from the Empower QA System***</span><br><br>' : '';

            $body = "
                {$customQABanner}
                
                <p><b>{$current_user->name}</b> has set the TR #{$trBean->technicalrequests_number_c} - Item: {$trItemName} as complete.</p>
                <p>You may <a href='{$triLink}'>review this {$customBody}</a>.</p>
            ";

            $mail->Body = from_html($body);

            foreach ($recipientsArray as $userBean) {
              $mail->AddAddress($userBean->emailAddress->getPrimaryAddress($userBean), $userBean->name);
            }

            $mail->AddBCC($sugar_config['systemBCCEmailAddress']);
            $mail->isHTML(true);
            $mail->prepForOutbound();
            $mail->Send();
          }
        }
      }
    }

    public function handleQtyChangedEmailNotification(&$bean, $event, $arguments)
    {
		if ($bean->fetched_row['qty'] != $bean->qty && $bean->qty > 0) {
			$bean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');

			$trIds = $bean->tri_technicalrequestitems_tr_technicalrequests->get();

			if (isset($bean->tri_technicalrequestitems_tr_technicalrequests) && isset($trIds) && count($trIds) > 0) {
				$trBean = BeanFactory::getBean('TR_TechnicalRequests', $trIds[0]);
				TechnicalRequestItemsHelper::sendTrItemUpdateEmail($trBean, $bean, 'qty_update');
			}
		}
    }

    public function insertTRIDocumentToTRDocumentsSubpanel(&$bean, $event, $arguments)
    {
      global $current_user, $log, $sugar_config;
      $bean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');

      $trIds = $bean->tri_technicalrequestitems_tr_technicalrequests->get();

      if (isset($bean->tri_technicalrequestitems_tr_technicalrequests) && isset($trIds) && count($trIds) > 0) {
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trIds[0]);

        if ($trBean->id && empty($_GET['entryPoint'])) {
            if (!empty($bean->document_c) && file_exists("{$sugar_config['upload_dir']}{$bean->id}_document_c")) {
              $trBean->load_relationship('tr_technicalrequests_documents');
              $tr_documents = $trBean->tr_technicalrequests_documents->getBeans();

              $is_file_exist = false;
              
              foreach($tr_documents as $tr_document){
                if (html_entity_decode($tr_document->document_name) == html_entity_decode($bean->document_c)) {
                    $is_file_exist = true;
                }
              }

              if (! $is_file_exist) {
                $docBean = BeanFactory::newBean('Documents');
                $docBean->status_id = 'Active';
                $docBean->doc_type = 'Sugar';
                $docBean->document_name = $bean->document_c;
                $docBean->assigned_user_id = $current_user->id;
                $docBean->assigned_user_name = $current_user->name;
                $docBean->upload_source_id = $bean->id;// Used by Document.php to properly rename file based on upload source id
                $docBean->category_id = 'TechnicalRequest';
                $docBean->save();

                $docBean->load_relationship('tr_technicalrequests_documents');

                if (isset($docBean->tr_technicalrequests_documents)) {				
                    $docBean->tr_technicalrequests_documents->add($trBean->id); // Link document and the selected module
                }

                $docRevision = new DocumentRevision();
                $docRevision->revision = 1;
                $docRevision->document_id = $docBean->id;
                // $docRevision->filename = $bean->id . '_' . $bean->document_c; -- OnTrack 1613: On Quote TRI, GUID should be exluded in File Name display
                $docRevision->filename = $bean->document_c;

                require_once('include/utils/file_utils.php');
                $extension = get_file_extension($_FILES['document_c_file']['name']);
                
                if (! empty($extension)) {
                    $docRevision->file_ext = $extension;
                    $docRevision->file_mime_type = get_mime_content_type_from_filename($_FILES['document_c_file']['name']);
                }

                $docRevision->save();

                $file = "{$sugar_config['upload_dir']}{$bean->id}_document_c";
                $newfile =  "{$sugar_config['upload_dir']}{$docRevision->id}";

                if (!copy($file, $newfile)) {
                    $log->fatal('failed to copy ' . $bean->document_c);
                }
              }
          }
        }
      }
    }

    public function handleTrItemStatusChanged(&$bean, $event, $arguments)
    {
      $distroItemsLabItemsList = DistributionHelper::$distro_items['Lab Items'];

      // If TR Item is under the Lab Item category
      if (in_array($bean->name, array_column($distroItemsLabItemsList, 'value'))) {
        // If status has been changed from any value to In Process
        if ($bean->status != $bean->fetched_row['status'] && $bean->status == 'in_process') {
          // Prevent TR Items Crud Workflow from running which causes issue where TR Items are removed due to missing access rights of user executing the hook
          $_REQUEST['skip_tr_items_crud_workflow'] = true;

          // Used to fix issue where it skips TR After Save Hooks and cause issues like incorrect assigned user despite Stage and Status changes
          $_REQUEST['skip_hook'] = true;

          // Retrieve TR Bean and set Stage to Development and Status to In Process
          if ($bean->tri_techni0387equests_ida) {
            $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tri_techni0387equests_ida);

            // If TR (Stage is not Understanding Requirements or Development) OR (Stage is Development and Status is not New), set TR Stage to Development and Status to In Process
            if ($trBean && $trBean->id && ((! in_array($trBean->approval_stage, ['understanding_requirements', 'development'])) || ($trBean->approval_stage == 'development' && (! in_array($trBean->status, ['new', 'approved_awaiting_target_resin', 'more_information', 'awaiting_target_resin']))))) {
              $trBean->approval_stage = 'development';
              $trBean->status = 'in_process';
              $trBean->save();
            }
          }
        }
      }
    }

    public function createOrUpdateTime(&$bean, $event, $arguments)
    {
      global $current_user, $log;

      if ($bean->work_performed_non_db != '' && $bean->time_non_db != '') {
          $timeBean = BeanFactory::getBean('Time')->retrieve_by_string_fields([
            'parent_type' => 'TRI_TechnicalRequestItems',
            'parent_id' => $bean->id
          ]);

          if (! in_array($bean->status, ['complete', 'rejected']) && ($timeBean && $timeBean->id)) {
            $timeBean->mark_deleted($timeBean->id);
          } else {
            $timeBean = ($timeBean && $timeBean->id) ? $timeBean : BeanFactory::newBean('Time');
            $timeBean->name = $bean->work_performed_non_db;
            $timeBean->time = $bean->time_non_db;
            $timeBean->date_worked = ($bean->date_worked_non_db) ? date_format(date_create($bean->date_worked_non_db), 'Y-m-d') : date('Y-m-d');
            $timeBean->description = $bean->work_description_non_db;
            $timeBean->parent_type = 'TRI_TechnicalRequestItems';
            $timeBean->parent_id = $bean->id;
            $timeBean->assigned_user_id = $current_user->id;
          }

          $timeBean->save();
      }
    }
    
    public function handleRemoveDocumentClicked(&$bean, $events, $arguments)
    {
      if (isset($_REQUEST['entryPoint']) && $_REQUEST['entryPoint'] == 'deleteFFAttachment') {
        $bean->load_relationship('tri_technicalrequestitems_tr_technicalrequests');

        $trIds = $bean->tri_technicalrequestitems_tr_technicalrequests->get();

        if (isset($bean->tri_technicalrequestitems_tr_technicalrequests) && isset($trIds) && count($trIds) > 0) {
          $trBean = BeanFactory::getBean('TR_TechnicalRequests', $trIds[0]);

          $trDocumentBeanList = $trBean->get_linked_beans(
            'tr_technicalrequests_documents',
            'Documents',
            array(),
            0,
            -1,
            0,
            "documents.document_name = '{$_REQUEST['document_c']}'"
          );

          if (isset($trDocumentBeanList) && count($trDocumentBeanList) > 0) {
            // Run foreach instead of just retrieving the first array value as there may be multiple files with the same name from the list
            foreach($trDocumentBeanList as $documentBean) {
              $documentBean->mark_deleted($documentBean->id);
              $documentBean->save();
            }
          }
        }
      }
    }

    public function handleCompletedColormatch(&$bean, $event, $arguments)
    {
      // If TR Type is Colormatch or Production Rematch and Colormatch TR Item has been set to Complete, fetch Quote TR Item and update status to In Process
      if ($bean->name == 'colormatch_task' && ($bean->fetched_row['status'] != $bean->status && $bean->status == 'complete')) {
        $trBean = BeanFactory::getBean('TR_TechnicalRequests', $bean->tri_techni0387equests_ida);

        if (($trBean && $trBean->id) && (in_array($trBean->type, ['color_match', 'rematch']))) {
          $trItemBeanList = $trBean->get_linked_beans(
            'tri_technicalrequestitems_tr_technicalrequests',
            'TRI_TechnicalRequestItems',
            array(),
            0,
            -1,
            0,
            "tri_technicalrequestitems.status IN ('new') AND tri_technicalrequestitems.name IN ('quote')"
          );

          if (! empty($trItemBeanList) && count($trItemBeanList) > 0) {
            foreach($trItemBeanList as $trItemBean) {
              $trItemBean->status = 'in_process';
              $trItemBean->save();
            }
          }
        }
      }
    }
}

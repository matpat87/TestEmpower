<?php

require_once('custom/modules/OTR_OnTrack/helpers/OTR_OnTrackHelper.php');

class OTR_OnTrackAfterSaveHook 
{


    function otr_track_time_after_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        
        $time_and_date = new TimeAndDateCustom();
        $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");
        
        if ($bean->add_time_non_db && $bean->work_performed_non_db != '' && $bean->time_non_db != '') {
        
            $timeBean = BeanFactory::newBean('Time');
            $timeBean->name = $bean->work_performed_non_db;
            $timeBean->time = $bean->time_non_db;
            $timeBean->date_worked = ($bean->date_worked_non_db) ? date_format(date_create($bean->date_worked_non_db), 'Y-m-d') : date('Y-m-d');
            $timeBean->description = $bean->work_description_non_db;
            $timeBean->parent_type = 'OTR_OnTrack';
            $timeBean->parent_id = $bean->id;
            $timeBean->assigned_user_id = $current_user->id;
            $timeBean->save();

        }

        
    }


    public function handleDocumentUpload(&$bean, $event, $arguments)
    {
        global $current_user, $log, $sugar_config;
        $fields = array( array('name' => 'otr_document_c', 'label' => 'File') );
        
        if(empty($_GET['entryPoint'])){ 
            foreach($fields as $field){
                
                if (!empty($bean->{$field['name']}) && file_exists($sugar_config['upload_dir'] . $bean->id . '_' . $field['name'])) {
                    $bean->load_relationship('documents_otr_ontrack_1');
                    $otr_ontrack_docs = $bean->documents_otr_ontrack_1->getBeans();

                    $is_file_exist = false;
                    foreach($otr_ontrack_docs as $otr_ontrack_doc){
                        if (html_entity_decode($otr_ontrack_doc->document_name) == html_entity_decode($bean->{$field['name']})) {
                            $is_file_exist = true;
                        }
                    }

                    if(!$is_file_exist){
                        $docBean = BeanFactory::newBean('Documents');
                        $docBean->status_id = 'Active';
                        $docBean->doc_type = 'Sugar';
                        $docBean->document_name = $bean->{$field['name']};
                        $docBean->assigned_user_id = $current_user->id;
                        $docBean->assigned_user_name = $current_user->name;
                        $docBean->upload_source_id = $bean->id;// Used by Document.php to properly rename file based on upload source id
                        $docBean->category_id = 'Other';
                        $docBean->subcategory_id = 'Other_Documentation';
                        $docBean->save();
                        
                        $docBean->load_relationship('documents_otr_ontrack_1');

                        if (isset($docBean->documents_otr_ontrack_1)) {				
                            $docBean->documents_otr_ontrack_1->add($bean->id); // Link document and the selected module
                        }

                        
                        $docRevision = new DocumentRevision();
                        $docRevision->revision = 1;
                        $docRevision->document_id = $docBean->id;
                        $docRevision->filename = $bean->{$field['name']};

                        require_once('include/utils/file_utils.php');
                        $extension = get_file_extension($_FILES['otr_document_c_file']['name']);
                        if (! empty($extension)) {
                            $docRevision->file_ext = $extension;
                            $docRevision->file_mime_type = get_mime_content_type_from_filename($_FILES['otr_document_c_file']['name']);
                        }
                        
                        $docRevision->save();

                        $file = $sugar_config['upload_dir'] . $bean->id . '_' . $field['name'];
                        $newfile =  $sugar_config['upload_dir'] . $docRevision->id;

                        if (!copy($file, $newfile)) {
                            $log->fatal('failed to copy' . $bean->id . '_' . $field['name']);
                        }
                    }
                }
            }
        }

        if ($bean->otr_document_c != null) {
            $this->handleCleanFileField($bean->id);
        }
    }

    
    protected function handleCleanFileField($ontrackId)
    {
        $db = DBManagerFactory::getInstance();

        $sql = "UPDATE otr_ontrack_cstm SET otr_document_c = NULL WHERE id_c = '{$ontrackId}'";
        $db->query($sql);
        return true;

    }


    function manage_ot_workgroup(&$bean, $event, $arguments){
        global $log, $current_user;
        $log->fatal('OTR_OnTrackBeforeSaveHook.manage_ot_workgroup: start');

        $bean->load_relationship('otr_ontrack_otw_otworkinggroups_1');
        
        if(!OTR_OnTrackHelper::is_workinggroup_role_exist($bean->id, 'Creator')){
            //Add Creator
            $ot_workinggroupbean = BeanFactory::newBean('OTW_OTWorkingGroups');
            $ot_workinggroupbean->name = $current_user->first_name . ' ' . $current_user->last_name;
            $ot_workinggroupbean->ot_role_c = 'Creator';
            $ot_workinggroupbean->parent_type = 'Users';
            $ot_workinggroupbean->parent_id = $current_user->id;
            $ot_workinggroupbean->first_name_c = $current_user->first_name;
            $ot_workinggroupbean->last_name_c = $current_user->last_name;
            $ot_workinggroupbean->save();
            $bean->otr_ontrack_otw_otworkinggroups_1->add($ot_workinggroupbean);

            //Business Analyst - to check with Steve because there is no Business Analyst role
            $business_analyst_user_id = OTR_OnTrackHelper::get_user($bean->division_c, '');
            $ot_workinggroupbean = BeanFactory::newBean('OTW_OTWorkingGroups');
            //$ot_workinggroupbean
        }

        $assigned_status_arr = array('1', '4', '5');
        if(in_array($bean->status, $assigned_status_arr) && !OTR_OnTrackHelper::is_workinggroup_role_exist($bean->id, 'Developer')){
            //Add Developer
            $user_bean = BeanFactory::getBean('Users', $bean->assigned_user_id);
            $ot_workinggroupbean = BeanFactory::newBean('OTW_OTWorkingGroups');
            $ot_workinggroupbean->name = $user_bean->first_name . ' ' . $user_bean->last_name;
            $ot_workinggroupbean->ot_role_c = 'Developer';
            $ot_workinggroupbean->parent_type = 'Users';
            $ot_workinggroupbean->parent_id = $user_bean->id;
            $ot_workinggroupbean->first_name_c = $user_bean->first_name;
            $ot_workinggroupbean->last_name_c = $user_bean->last_name;
            $ot_workinggroupbean->save();
            $bean->otr_ontrack_otw_otworkinggroups_1->add($ot_workinggroupbean);
        }

        $assigned_status_arr = array('7');
        if(in_array($bean->status, $assigned_status_arr) && !OTR_OnTrackHelper::is_workinggroup_role_exist($bean->id, 'QualityAnalyst')){
            //Add Developer
            $user_bean = BeanFactory::getBean('Users', $bean->assigned_user_id);
            $ot_workinggroupbean = BeanFactory::newBean('OTW_OTWorkingGroups');
            $ot_workinggroupbean->name = $user_bean->first_name . ' ' . $user_bean->last_name;
            $ot_workinggroupbean->ot_role_c = 'QualityAnalyst';
            $ot_workinggroupbean->parent_type = 'Users';
            $ot_workinggroupbean->parent_id = $user_bean->id;
            $ot_workinggroupbean->first_name_c = $user_bean->first_name;
            $ot_workinggroupbean->last_name_c = $user_bean->last_name;
            $ot_workinggroupbean->save();
            $bean->otr_ontrack_otw_otworkinggroups_1->add($ot_workinggroupbean);
        }

        //$ot_workinggroupbean->
        
        $log->fatal('OTR_OnTrackBeforeSaveHook.manage_ot_workgroup: end');

        //die();
    }
}

?>
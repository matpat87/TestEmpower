<?php


class RMM_RawMaterialMasterAfterSaveHook 
{

    public function handleDocumentUpload(&$bean, $event, $arguments)
        {
            global $current_user, $log, $sugar_config;
            $fields = array( array('name' => 'tds_c', 'label' => 'Technical Data Sheet'), 
                array('name' => 'sds_c', 'label' => 'Safety Data Sheet'));
            
            if(empty($_GET['entryPoint'])){ 
                foreach($fields as $field){
                    
                    if (!empty($bean->{$field['name']}) && file_exists($sugar_config['upload_dir'] . $bean->id . '_' . $field['name'])) {
                        $bean->load_relationship('rmm_rawmaterialmaster_documents');
                        $rmm_documents = $bean->rmm_rawmaterialmaster_documents->getBeans();

                        $is_file_exist = false;
                        foreach($rmm_documents as $rmm_document){
                            if (html_entity_decode($rmm_document->document_name) == html_entity_decode($bean->{$field['name']})) {
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
                            $docBean->category_id = 'TechnicalRequest';
                            $docBean->subcategory_id = ($field['label'] == 'Technical Data Sheet') ? 'TechnicalRequest_TDS' : 'TechnicalRequest_SDS';
                            $docBean->save();

                            $docBean->load_relationship('rmm_rawmaterialmaster_documents');

                            if (isset($docBean->rmm_rawmaterialmaster_documents)) {				
                                $docBean->rmm_rawmaterialmaster_documents->add($bean->id); // Link document and the selected module
                            }

                            $docRevision = new DocumentRevision();
                            $docRevision->revision = 1;
                            $docRevision->document_id = $docBean->id;
                            // $docRevision->filename = $bean->id . '_' . $field['name']; -- OnTrack 1613: On any file upload, GUID should be exluded in File Name display
                            $docRevision->filename = $field['name'];
                            //$docRevision->file_ext = 'pdf';
                            //$docRevision->file_mime_type = 'application/pdf';
                            //$docRevision->assigned_user_id = $this->idUsr;
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
        }
  
}

?>
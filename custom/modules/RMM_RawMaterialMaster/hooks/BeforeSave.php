<?php


class RMM_RawMaterialMasterBeforeSaveHook 
{

    function check_product_number(&$bean, $event, $arguments) 
    {
        global $current_user, $log, $db;
        
        if (! $bean->fetched_row['id']) {
            // Retrieve or increment lates project number
            $db = DBManagerFactory::getInstance();

            // $sql= "SELECT vi_vendorissues_number FROM vi_vendorissues WHERE deleted = 0 ORDER BY date_entered DESC LIMIT 1";
            // $result = $db->query($sql);
            // $row = $db->fetchByAssoc($result);
            // $bean->vi_vendorissues_number = $row['vi_vendorissues_number'] + 1;
        
        }
        
    }

    // public function handleDocumentUpload(&$bean, $event, $arguments)
    // {
    //         global $current_user;
            
    //         if (! empty($_FILES['tds_c_file']) || !empty($_FILES['sds_c_file']['tmp_name'])) {
    //             $date = date('Y-m-d');
    //             $dateTimeStr = strtotime(date('h:i:s'));

    //             $docBean = BeanFactory::newBean('Documents');
    //             $docBean->filename = $bean->tds_c;
    //             $docBean->status_id = 'Active';
    //             $docBean->doc_type = 'Sugar';
    //             $docBean->document_name = "TEST-{$date}-{$dateTimeStr}";
    //             $docBean->assigned_user_id = $current_user->id;
    //             $docBean->assigned_user_name = $current_user->name;
    //             $docBean->upload_source_id = $bean->id; // Used by Document.php to properly rename file based on upload source id
    //             $docBean->save();

    //             $docBean->load_relationship('rmm_rawmaterialmaster_documents');

    //             if (isset($docBean->rmm_rawmaterialmaster_documents)) {				
    //                 $docBean->rmm_rawmaterialmaster_documents->add($bean->id); // Link document and the selected module
    //             }
    //         }
    // }
  
}

?>
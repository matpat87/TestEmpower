<?php
require_once('custom/include/Carbon/src/Carbon/Carbon.php');
use Carbon\Carbon;

class VendorsAfterSaveHook
{
    public function handleCodeOfConductDocumentUpload($bean, $event, $arguments)
    {
        global $log, $db, $current_user, $sugar_config;
        $currentDate = Carbon::now();
        $twoYearsLater = $currentDate->addYears(2);

        // $log->fatal(print_r($twoYearsLater, true));
        //     $log->fatal(print_r($_FILES['code_of_conduct_c'], true));
        if (!empty($bean->code_of_conduct_c) && file_exists($sugar_config['upload_dir'] . $bean->id . '_code_of_conduct_c')) {
            $bean->load_relationship('vend_vendors_documents_1');
            $vendorDocuments = $bean->vend_vendors_documents_1->getBeans();

            $is_file_exist = false;
            foreach($vendorDocuments as $vendorDocument){
                if (html_entity_decode($vendorDocument->document_name) == html_entity_decode($bean->code_of_conduct_c)) {
                    $is_file_exist = true;
                }
            }

            if(!$is_file_exist){

                // set Exp Date default to 2 years from Current Date
                $currentDate = Carbon::now();
                $twoYearsLater = $currentDate->addYears(2);

                $docBean = BeanFactory::newBean('Documents');
                $docBean->status_id = 'Active';
                $docBean->doc_type = 'Sugar';
                $docBean->document_name = $bean->code_of_conduct_c;
                $docBean->assigned_user_id = $current_user->id;
                $docBean->assigned_user_name = $current_user->name;
                $docBean->upload_source_id = $bean->id;// Used by Document.php to properly rename file based on upload source id
                $docBean->category_id = 'Vendor';
                $docBean->subcategory_id = 'Vendor_Code_of_Conduct';
                $docBean->exp_date = Carbon::parse($twoYearsLater)->format('Y-m-d');
                $docBean->save();
                
                $docBean->load_relationship('vend_vendors_documents_1');

                if (isset($docBean->vend_vendors_documents_1)) {				
                    $docBean->vend_vendors_documents_1->add($bean->id); // Link document and the selected module
                }

                
                $docRevision = new DocumentRevision();
                $docRevision->revision = 1;
                $docRevision->document_id = $docBean->id;
                $docRevision->filename = $bean->code_of_conduct_c;

                require_once('include/utils/file_utils.php');
                $extension = get_file_extension($_FILES['code_of_conduct_c']['name']);
                if (! empty($extension)) {
                    $docRevision->file_ext = $extension;
                    $docRevision->file_mime_type = get_mime_content_type_from_filename($_FILES['otr_document_c_file']['name']);
                }
                
                $docRevision->save();

                $file = $sugar_config['upload_dir'] . $bean->id . '_code_of_conduct_c';
                $newfile =  $sugar_config['upload_dir'] . $docRevision->id;

                if (!copy($file, $newfile)) {
                    $log->fatal('failed to copy' . $bean->id . '_code_of_conduct_c');
                }
            }
        }
    }


} // end of class

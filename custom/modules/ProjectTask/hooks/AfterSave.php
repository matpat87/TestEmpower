<?php
// require_once('include/SugarObjects/templates/file/File.php');

class ProjectTaskAfterSaveHook 
{
	function otr_track_time_after_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
        
        $time_and_date = new TimeAndDateCustom();
        $current_datetime_timestamp = $time_and_date->customeDateFormatter($time_and_date->new_york_format, "D m/d/Y g:iA");

        if ($bean->work_performed_non_db != '' && $bean->time_non_db != '') {
        
            $timeBean = BeanFactory::newBean('Time');
            $timeBean->name = $bean->work_performed_non_db;
            $timeBean->time = $bean->time_non_db;
            $timeBean->date_worked = ($bean->date_worked_non_db) ? date_format(date_create($bean->date_worked_non_db), 'Y-m-d') : date('Y-m-d');
            $timeBean->description = $bean->work_description_non_db;
            $timeBean->parent_type = 'ProjectTask';
            $timeBean->parent_id = $bean->id;
            $timeBean->assigned_user_id = $current_user->id;
            $timeBean->save();

        }

        
    }

    function document_save(&$bean, $event, $arguments)
    {
        global $current_user, $log;
		
		if (! empty($_FILES['filename_file']) && !empty($_FILES['filename_file']['tmp_name'])) {
			
			$docBean = BeanFactory::newBean('Documents');
			$docBean->filename = $bean->filename;
			$docBean->status_id = 'Active';
			$docBean->doc_type = 'Sugar';
			$docBean->document_name = $bean->document_name;
			$docBean->assigned_user_id = $current_user->id;
			$docBean->assigned_user_name = $current_user->name;
			// $docBean->parent_type = 'ProjectTask';
			// $docBean->parent_id = $bean->id;
			$docBean->upload_source_id = $bean->id; // Used by Document.php to properly rename file based on upload source id
            $docBean->category_id = 'Other';
            $docBean->subcategory_id = 'Other_Documentation';
			$docBean->save();

			$docBean->load_relationship('projecttask_documents_1');

			if(isset($docBean->projecttask_documents_1)) {				
				$docBean->projecttask_documents_1->add($bean->id); // Link document and the selected module
			}

		}
    }
    
}

?>
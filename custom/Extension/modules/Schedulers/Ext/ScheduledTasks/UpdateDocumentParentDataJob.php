<?php

handleVerifyBeforeRequire('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

class UpdateDocumentParentDataJob implements RunnableSchedulerJob
{
    public function run($arguments)
    {
        $db = DBManagerFactory::getInstance();
        $documentsQuery = $db->query("SELECT documents.id FROM documents WHERE ((parent_id IS NULL OR parent_type IS NULL) OR (parent_id ='' OR parent_id='')) AND documents.deleted = 0");
        $excludedModules = [
            'created_by_link', 
            'modified_user_link', 
            'assigned_user_link', 
            'SecurityGroups', 
            'revisions', 
            'contracts', 
            'so_savingopportunities_documents', 
            'bugs'];
       
        $GLOBALS['log']->fatal('UPDATE DOCUMENT PARENT DATA JOB - START');
        
        while($row = $db->fetchByAssoc($documentsQuery)) {

            $documentBean = BeanFactory::getBean('Documents', $row['id']);

            $linkedFields = $documentBean->get_linked_fields(); // get all modules related to the document
            
            foreach ($linkedFields as $relationship => $attrs) {
                if (
                    (! in_array($relationship, $excludedModules)) && 
                      $documentBean->load_relationship($relationship) && 
                      $documentBean->{$relationship}->get()
                  ) {
                    $moduleName = $attrs['module'] ?? ucfirst($attrs['name']);
                    $relatedBeanIds = $documentBean->{$relationship}->get();
                    $relatedBean = BeanFactory::getBean($moduleName, $relatedBeanIds[0]);
          
                    if (! $relatedBean->id) continue;
          
                    $query = "UPDATE documents 
                              SET documents.parent_type = '{$moduleName}', documents.parent_id ='{$relatedBean->id}' 
                              WHERE documents.id = '{$row['id']}'
                            ";
          
                    $db->query($query);

                    $GLOBALS['log']->fatal("UPDATE DOCUMENT PARENT DATA JOB QUERY: {$query}");
                    break;
                }

            }
            
        
        } // End of While
        $GLOBALS['log']->fatal('UPDATE DOCUMENT PARENT DATA JOB - END');
        return true;
    }

    public function setJob(SchedulersJob $job)
    {
        $this->job = $job;
    }
}
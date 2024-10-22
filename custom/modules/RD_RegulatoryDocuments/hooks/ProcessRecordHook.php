<?php

class RD_RegulatoryDocumentsProcessRecordHook 
{
    public function handleFileLinkColumn(&$bean, $event, $arguments)
    {
        global $log;
        $bean->uploadfile = 'test';
        $bean->uploadfile = "
            <a href=\"index.php?preview=no&amp;entryPoint=download&amp;id={$bean->id}&amp;type=RD_RegulatoryDocuments\" class=\"tabDetailViewDFLink\" target=\"_blank\" style=\"border-bottom: 0px;\">
            {$bean->document_name}
            </a>
        ";

        if ($_REQUEST['action'] == 'DetailView' && in_array($_REQUEST['module'], ['RRQ_RegulatoryRequests'])) {
            $log->fatal(print_r($_REQUEST, true));
            $bean->filename = "
                <a href=\"index.php?preview=no&amp;entryPoint=download&amp;id={$bean->id}&amp;type=RD_RegulatoryDocuments\" class=\"tabDetailViewDFLink\" target=\"_blank\" style=\"border-bottom: 0px;\">
                {$bean->document_name} <i class=\"glyphicon glyphicon-eye-open\"></i>
                </a>
            ";

        }

    }
  
}
<?php


class APR_AccountProfileReportProcessRecord 
{
    public function handleCustomReportLink(&$bean, $event, $arguments)
    {
        global $log;

        $bean->name = "
            <a href='index.php?entryPoint=AccountProfileReport&amp;account_id={$bean->id}' target='_blank'>{$bean->name}</a>
        ";
        
    }
    
  
}
<?php

require_once 'include/MVC/View/views/view.detail.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
class PA_EHSActionItemsViewDetail extends ViewDetail
{
    function display()
    {
        global $log;
        $this->bean->status_update_log_c = htmlspecialchars_decode($this->bean->status_update_log_c);
        
        parent::display();

        echo <<<EOF
            <style type="text/css"> 
            #status_update_log_c {
                height: 200px;
                line-height: 20px;
                display: block;
                overflow-y:scroll;
            }
            </style>';
EOF;
    }
}   
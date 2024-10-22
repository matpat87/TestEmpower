<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once ("include/MVC/View/views/view.popup.php");

class ContactsViewPopup extends ViewPopup
{

    public function display()
    {
        global $log;
        echo getVersionedScript('custom/modules/Contacts/js/custom-quickcreate.js');
        parent::display();
    }


}
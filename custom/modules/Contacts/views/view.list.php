<?php
require_once('include/json_config.php');
require_once('include/MVC/View/views/view.list.php');
require_once('modules/Contacts/views/view.list.php');  

class CustomContactsViewList extends ViewList {       
    function listViewPrepare() {               

          if (empty($_REQUEST['orderBy'])) {  
              $_REQUEST['orderBy'] = 'first_name';                          
          } 
          
          if (empty($_REQUEST['Contacts2_CONTACT_ORDER_BY'])) { 
              $_REQUEST['Contacts2_CONTACT_ORDER_BY'] = 'first_name';
          }

          // Set filter of both admin and regular users to show 'Active' accounts by default
          if(!isset($_REQUEST['status_c_advanced'])) {
              $_REQUEST['status_c_advanced'][0] = 'Active';
          }
          
          $this->bean->field_defs['name']['sort_on'] = 'first_name';

          parent::listViewPrepare(); 
       }
}

 
?>
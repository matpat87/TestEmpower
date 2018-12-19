<?php
/**
 * Add a Login as button in DetailView
 *
 * @author Steven Kyamko <stevenkyamko@gmail.com>
 * @date 6/13/2018
 */

require_once('include/json_config.php');
require_once('include/MVC/View/views/view.detail.php');
require_once('modules/Users/views/view.detail.php');

class CustomUsersViewDetail extends UsersViewDetail
{
    public function UsersViewDetail()
    {
        parent::UsersViewDetail();
    }

    public function preDisplay()
    {
        global $current_user, $app_strings, $sugar_config;

        parent::preDisplay();
        
    }

    public function display()
   {
      
      parent::display();
   }
}
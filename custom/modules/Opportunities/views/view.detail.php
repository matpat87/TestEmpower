<?php
/**
 * Customize Opportunity detail view
 *
 * @author Steven Kyamko <stevenkyamko@gmail.com>
 * @date_created 6/15/2018 - for changes, see OnTrack module - Number 5
 */

require_once('include/json_config.php');
require_once('include/MVC/View/views/view.detail.php');
require_once('modules/Opportunities/views/view.detail.php');

class CustomOpportunitiesViewDetail extends OpportunitiesViewDetail
{
    public function OpportunitiesViewDetail()
    {
        parent::OpportunitiesViewDetail();
    }

    public function preDisplay()
    {
        global $current_user, $app_strings, $sugar_config;
        parent::preDisplay();
        
    }

    public function display()
   {
      //format amount
      if(isset($this->bean->amount))
      {
        $bean_amount = "$" . number_format($this->bean->amount, 2, '.', ',');
        $this->ss->assign('AMOUNT', $bean_amount);
      }

      parent::display();
    }
}
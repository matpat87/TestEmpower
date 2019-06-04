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
      $metadataFile = $this->getMetaDataFile();
      $this->dv = new DetailView2();
      $this->dv->ss =&  $this->ss;
      $this->dv->setup($this->module, $this->bean, $metadataFile, 'include/DetailView/DetailView.tpl');
    }

    public function display()
   {
      //format amount
      if(isset($this->bean->amount))
      {
        $bean_amount = "$" . number_format($this->bean->amount, 2, '.', ',');
        $this->ss->assign('AMOUNT', $bean_amount);
      }

      if(isset($this->bean->avg_sell_price_c))
      {
        $bean_avg_sell_price_c = "$" . number_format($this->bean->avg_sell_price_c, 2, '.', ',');
        $this->ss->assign('AVG_SELL_PRICE', $bean_avg_sell_price_c);
      }

      //SKY 10/24 - enables the next_step html to be shown in UI 
      $this->bean->next_step = htmlspecialchars_decode($this->bean->next_step);

      parent::display();

      echo <<<EOF
      <style type="text/css"> 
        #next_step {
          height: 200px;
          line-height: 20px;
          display: block;
          overflow-y:scroll
        }

      </style>';
EOF;
    }
}
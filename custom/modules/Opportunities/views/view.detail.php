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
require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');

class CustomOpportunitiesViewDetail extends OpportunitiesViewDetail
{
    public function preDisplay()
    {
      $metadataFile = $this->getMetaDataFile();
      $this->dv = new DetailView2();
      $this->dv->ss =&  $this->ss;
      $this->dv->setup($this->module, $this->bean, $metadataFile, 'include/DetailView/DetailView.tpl');
    }

    public function display()
    {
      global $app_list_strings, $log;
      
      //format amount
      $this->bean->amount = NumberHelper::GetCurrencyValue($this->bean->amount);
      $this->bean->avg_sell_price_c = NumberHelper::GetCurrencyValue($this->bean->avg_sell_price_c);
      $this->bean->amount_weighted_c = NumberHelper::GetCurrencyValue($this->bean->amount_weighted_c);

      //SKY 10/24 - enables the next_step html to be shown in UI 
      $this->bean->next_step = htmlspecialchars_decode($this->bean->next_step);
      
      if ($this->bean->mkt_markets_opportunities_1mkt_markets_ida != '') {
        $industryLink ="<a href='index.php?module=MKT_Markets&amp;action=DetailView&amp;record={$this->bean->mkt_markets_opportunities_1mkt_markets_ida}'><span id='mkt_markets_opportunities_1mkt_markets_ida' class='sugar_field' data-id-value='{$this->bean->mkt_markets_opportunities_1mkt_markets_ida}'>{$app_list_strings['industry_dom'][$this->bean->industry_c]}</span>";

      } else {
        $industryLink = $app_list_strings['industry_dom'][$this->bean->industry_c];
      }
      
      if (!empty($this->bean->sub_industry_c)) {
        $industryBean = BeanFactory::getBean("MKT_Markets", $this->bean->sub_industry_c);
        $subIndustryStr = $industryBean->sub_industry_c;
      } else {
        $subIndustryStr = "";
      }
  
      $this->ss->assign('INDUSTRY_NAME', $industryLink);
      $this->ss->assign('SUB_INDUSTRY_NAME', $subIndustryStr);

      $this->ss->assign('CUSTOM_STATUS_DISPLAY', $this->bean->sales_stage && $this->bean->status_c ? OpportunitiesHelper::get_status($this->bean->sales_stage)[$this->bean->status_c] : '');
      $this->ss->assign('OPPORTUNITY_ID', $this->bean->id);
      
      if ($this->bean->last_activity_type_c && $this->bean->last_activity_id_c) {
        if ($this->bean->last_activity_type_c == 'Technical Requests') {
            $customActivityType = 'TR_TechnicalRequests';
        } else {
            $customActivityType = $this->bean->last_activity_type_c;
        }
        
        $customActivityLink = "/index.php?module={$customActivityType}&offset=1&return_module={$customActivityType}&action=DetailView&record={$this->bean->last_activity_id_c}";
        $this->ss->assign("custom_last_activity_link", $customActivityLink);
      }

      parent::display();

      echo "<script>
        var panel_bg_color = 'var(--custom-panel-bg)';
	
        $(\"div[field='workflow_section_non_db'], div[field='overview_section_non_db'], div[field='marketing_information_non_db']\")
          .addClass('hidden')
          .prev()
          .removeClass('col-sm-2')
          .addClass('col-sm-12')
          .addClass('col-md-12')
          .addClass('col-lg-12')
          .css('background-color', panel_bg_color)
          .css('color', '#FFF')
          .css('margin-top', '15px');

        $(\"div[field='workflow_section_non_db']\")
          .prev()
          .css('margin-top', '0px');
      </script>";

      echo <<<EOF
      <style type="text/css"> 
        #next_step {
          height: 200px;
          line-height: 20px;
          display: block;
          overflow-y:scroll
        }
      </style>
EOF;
    }
}
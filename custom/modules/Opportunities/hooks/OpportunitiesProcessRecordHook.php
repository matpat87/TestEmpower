<?php
  require_once('custom/modules/Opportunities/helpers/OpportunitiesHelper.php');
  use Carbon\Carbon;

  class OpportunitiesProcessRecordHook
  {
    public function processCustomColumnDisplay($bean, $event, $arguments)
    {
      global $app_list_strings;

      $oppBean = BeanFactory::getBean('Opportunities', $bean->id);

      $bean->status_c = $bean->sales_stage && $bean->status_c ? OpportunitiesHelper::get_status($bean->sales_stage)[$bean->status_c] : '';
      $bean->opp_id_non_db = $oppBean->oppid_c;

      if ($_REQUEST['customRequestDashletName'] == 'MyTeamsTopOpportunitiesDashlet' || $_REQUEST['customRequestDashletName'] == 'MyOpportunitiesDashlet') {
        $threeDaysBeforeExpectedCloseDate = Carbon::parse($bean->date_closed)->subDays(3);
        $dateTimeNow = getUserDateTimeNow();
        

        if (! $bean->sales_stage) {
          $addRedTextClass = ($threeDaysBeforeExpectedCloseDate->lessThanOrEqualTo($dateTimeNow) && strpos($oppBean->sales_stage, 'Closed') === false) ? "text-red-important" : "";
        } else {
          $addRedTextClass = ($threeDaysBeforeExpectedCloseDate->lessThanOrEqualTo($dateTimeNow) && strpos($bean->sales_stage, 'Closed') === false) ? "text-red-important" : "";
        }

        $bean->name = "<a class='{$addRedTextClass}' href='index.php?action=DetailView&module=Opportunities&record={$bean->id}'>{$bean->name}</a>";
        $bean->date_closed = "<span class='{$addRedTextClass}'>$bean->date_closed</span>";
      }

        // Sub-Industry Column
        if ($bean->sub_industry_c && !empty($bean->sub_industry_c)) {
          $industryBean = BeanFactory::getBean('MKT_Markets', $bean->sub_industry_c);
          $bean->sub_industry_c = isset($industryBean->id) ? $industryBean->sub_industry_c : '';
        }
        
        if ($bean->industry_c && !empty($bean->industry_c)) {
          $bean->industry_c = $app_list_strings['industry_dom'][$bean->industry_c];
        }
      
    }
  }
?>
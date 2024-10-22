<?php
  class CustomerProductProcessRecordHook
  {
    public function processCustomColumnStyle($bean, $event, $arguments)
    {
      $productMaster = $bean->product_number_c ? "{$bean->product_number_c}.{$bean->version_c}" : '';
      $customerProductBean = BeanFactory::getBean('CI_CustomerItems', $bean->id);
      
      $bean->ci_name_non_db = $customerProductBean->name;
      if ((isset($_REQUEST['action']) && $_REQUEST['action'] !== 'Popup') && $customerProductBean->aos_products_ci_customeritems_1aos_products_ida) {
        $bean->product_master_non_db = "
          <a href='index.php?module=AOS_Products&action=DetailView&record={$customerProductBean->aos_products_ci_customeritems_1aos_products_ida}'>
            <span class='sugar_field'>{$productMaster}</span>
          </a>";
      } else {
        $bean->product_master_non_db = "<span class='sugar_field'>{$productMaster}</span>";
      }

      // Sub-Industry Column
      if ($bean->sub_industry_c && !empty($bean->sub_industry_c)) {
        $industryBean = BeanFactory::getBean('MKT_Markets', $bean->sub_industry_c);
        $bean->sub_industry_c = isset($industryBean->id) ? $industryBean->sub_industry_c : '';
      }
    }
  }
?>
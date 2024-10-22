<?php
  class RMM_RawMaterialMasterProcessRecordHook
  {
    public function process_product_number_column($bean, $event, $arguments)
    {
        // if ($bean->product_number != '') {
        //     $bean->product_number = "
        //     <a href='index.php?module=RMM_RawMaterialMaster&action=DetailView&record={$bean->id}'>
        //         <span class='sugar_field'>{$bean->product_number}</span>
        //     </a>";
        // }
    }
  }
?>
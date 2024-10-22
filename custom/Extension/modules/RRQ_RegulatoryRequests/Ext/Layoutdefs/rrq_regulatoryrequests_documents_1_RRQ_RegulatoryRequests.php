<?php
 // created: 2022-10-09 09:16:28
$layout_defs["RRQ_RegulatoryRequests"]["subpanel_setup"]['rrq_regulatoryrequests_documents_1'] = array (
  'order' => 100,
  'module' => 'Documents',
  'subpanel_name' => 'default',
  'sort_order' => 'asc',
  'sort_by' => 'id',
  'title_key' => 'LBL_RRQ_REGULATORYREQUESTS_DOCUMENTS_1_FROM_DOCUMENTS_TITLE',
  'get_subpanel_data' => 'rrq_regulatoryrequests_documents_1',
  'top_buttons' => 
  array (
    0 => 
    array (
      'widget_class' => 'SubPanelTopButtonQuickCreate',
    ),
    1 => 
    array (
      'widget_class' => 'SubPanelTopSelectButton',
      'mode' => 'MultiSelect',
    ),
  ),
);
/* Ontrack #1740: Migrated to Regulatory Documents instead of Documents (Glai Obido)
   Unset the Documents subpanel but did not removed the relationship
   Reason: to retain copies of previously related documents in case the migration has gaps; this will serve as a backup before the migration
*/
//unset($layout_defs["RRQ_RegulatoryRequests"]["subpanel_setup"]['rrq_regulatoryrequests_documents_1']);
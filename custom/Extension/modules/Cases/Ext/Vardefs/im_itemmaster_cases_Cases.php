<?php
// created: 2019-01-14 16:45:34
$dictionary["Case"]["fields"]["im_itemmaster_cases"] = array (
  'name' => 'im_itemmaster_cases',
  'type' => 'link',
  'relationship' => 'im_itemmaster_cases',
  'source' => 'non-db',
  'module' => 'IM_ItemMaster',
  'bean_name' => false,
  'vname' => 'LBL_IM_ITEMMASTER_CASES_FROM_IM_ITEMMASTER_TITLE',
  'id_name' => 'im_itemmaster_casesim_itemmaster_ida',
);
$dictionary["Case"]["fields"]["im_itemmaster_cases_name"] = array (
  'name' => 'im_itemmaster_cases_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_IM_ITEMMASTER_CASES_FROM_IM_ITEMMASTER_TITLE',
  'save' => true,
  'id_name' => 'im_itemmaster_casesim_itemmaster_ida',
  'link' => 'im_itemmaster_cases',
  'table' => 'im_itemmaster',
  'module' => 'IM_ItemMaster',
  'rname' => 'name',
);
$dictionary["Case"]["fields"]["im_itemmaster_casesim_itemmaster_ida"] = array (
  'name' => 'im_itemmaster_casesim_itemmaster_ida',
  'type' => 'link',
  'relationship' => 'im_itemmaster_cases',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_IM_ITEMMASTER_CASES_FROM_CASES_TITLE',
);

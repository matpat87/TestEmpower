<?php
// created: 2019-01-15 14:53:45
$dictionary["Note"]["fields"]["im_itemmaster_notes_1"] = array (
  'name' => 'im_itemmaster_notes_1',
  'type' => 'link',
  'relationship' => 'im_itemmaster_notes_1',
  'source' => 'non-db',
  'module' => 'IM_ItemMaster',
  'bean_name' => 'IM_ItemMaster',
  'vname' => 'LBL_IM_ITEMMASTER_NOTES_1_FROM_IM_ITEMMASTER_TITLE',
  'id_name' => 'im_itemmaster_notes_1im_itemmaster_ida',
);
$dictionary["Note"]["fields"]["im_itemmaster_notes_1_name"] = array (
  'name' => 'im_itemmaster_notes_1_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_IM_ITEMMASTER_NOTES_1_FROM_IM_ITEMMASTER_TITLE',
  'save' => true,
  'id_name' => 'im_itemmaster_notes_1im_itemmaster_ida',
  'link' => 'im_itemmaster_notes_1',
  'table' => 'im_itemmaster',
  'module' => 'IM_ItemMaster',
  'rname' => 'name',
);
$dictionary["Note"]["fields"]["im_itemmaster_notes_1im_itemmaster_ida"] = array (
  'name' => 'im_itemmaster_notes_1im_itemmaster_ida',
  'type' => 'link',
  'relationship' => 'im_itemmaster_notes_1',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_IM_ITEMMASTER_NOTES_1_FROM_NOTES_TITLE',
);

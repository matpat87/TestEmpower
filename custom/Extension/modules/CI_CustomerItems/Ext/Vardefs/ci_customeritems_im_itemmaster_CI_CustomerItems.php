<?php
// created: 2019-02-04 16:24:24
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_im_itemmaster"] = array (
  'name' => 'ci_customeritems_im_itemmaster',
  'type' => 'link',
  'relationship' => 'ci_customeritems_im_itemmaster',
  'source' => 'non-db',
  'module' => 'IM_ItemMaster',
  'bean_name' => 'IM_ItemMaster',
  'vname' => 'LBL_CI_CUSTOMERITEMS_IM_ITEMMASTER_FROM_IM_ITEMMASTER_TITLE',
  'id_name' => 'ci_customeritems_im_itemmasterim_itemmaster_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_im_itemmaster_name"] = array (
  'name' => 'ci_customeritems_im_itemmaster_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_IM_ITEMMASTER_FROM_IM_ITEMMASTER_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_im_itemmasterim_itemmaster_ida',
  'link' => 'ci_customeritems_im_itemmaster',
  'table' => 'im_itemmaster',
  'module' => 'IM_ItemMaster',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_im_itemmasterim_itemmaster_ida"] = array (
  'name' => 'ci_customeritems_im_itemmasterim_itemmaster_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_im_itemmaster',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_CI_CUSTOMERITEMS_IM_ITEMMASTER_FROM_CI_CUSTOMERITEMS_TITLE',
);

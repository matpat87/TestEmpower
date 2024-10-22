<?php
// created: 2020-11-26 08:36:39
$dictionary["VP_VendorProducts"]["fields"]["vp_vendorproducts_rmm_rawmaterialmaster"] = array (
  'name' => 'vp_vendorproducts_rmm_rawmaterialmaster',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_rmm_rawmaterialmaster',
  'source' => 'non-db',
  'module' => 'RMM_RawMaterialMaster',
  'bean_name' => 'RMM_RawMaterialMaster',
  'vname' => 'LBL_VP_VENDORPRODUCTS_RMM_RAWMATERIALMASTER_FROM_RMM_RAWMATERIALMASTER_TITLE',
  'id_name' => 'vp_vendorproducts_rmm_rawmaterialmasterrmm_rawmaterialmaster_ida',
);
$dictionary["VP_VendorProducts"]["fields"]["vp_vendorproducts_rmm_rawmaterialmaster_name"] = array (
  'name' => 'vp_vendorproducts_rmm_rawmaterialmaster_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_VP_VENDORPRODUCTS_RMM_RAWMATERIALMASTER_FROM_RMM_RAWMATERIALMASTER_TITLE',
  'save' => true,
  'id_name' => 'vp_vendorproducts_rmm_rawmaterialmasterrmm_rawmaterialmaster_ida',
  'link' => 'vp_vendorproducts_rmm_rawmaterialmaster',
  'table' => 'rmm_rawmaterialmaster',
  'module' => 'RMM_RawMaterialMaster',
  'rname' => 'name',
);
$dictionary["VP_VendorProducts"]["fields"]["vp_vendorproducts_rmm_rawmaterialmasterrmm_rawmaterialmaster_ida"] = array (
  'name' => 'vp_vendorproducts_rmm_rawmaterialmasterrmm_rawmaterialmaster_ida',
  'type' => 'link',
  'relationship' => 'vp_vendorproducts_rmm_rawmaterialmaster',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'right',
  'vname' => 'LBL_VP_VENDORPRODUCTS_RMM_RAWMATERIALMASTER_FROM_VP_VENDORPRODUCTS_TITLE',
);

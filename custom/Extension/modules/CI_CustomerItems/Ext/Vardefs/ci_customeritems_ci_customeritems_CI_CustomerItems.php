<?php
// created: 2019-02-04 16:24:24
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_ci_customeritems"] = array (
  'name' => 'ci_customeritems_ci_customeritems',
  'type' => 'link',
  'relationship' => 'ci_customeritems_ci_customeritems',
  'source' => 'non-db',
  'module' => 'CI_CustomerItems',
  'bean_name' => false,
  'vname' => 'LBL_CI_CUSTOMERITEMS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_L_TITLE',
  'id_name' => 'ci_customeritems_ci_customeritemsci_customeritems_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_ci_customeritems"] = array (
  'name' => 'ci_customeritems_ci_customeritems',
  'type' => 'link',
  'relationship' => 'ci_customeritems_ci_customeritems',
  'source' => 'non-db',
  'module' => 'CI_CustomerItems',
  'bean_name' => false,
  'vname' => 'LBL_CI_CUSTOMERITEMS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_R_TITLE',
  'id_name' => 'ci_customeritems_ci_customeritemsci_customeritems_ida',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_ci_customeritems_name"] = array (
  'name' => 'ci_customeritems_ci_customeritems_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_R_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_ci_customeritemsci_customeritems_ida',
  'link' => 'ci_customeritems_ci_customeritems',
  'table' => 'ci_customeritems',
  'module' => 'CI_CustomerItems',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_ci_customeritems_name"] = array (
  'name' => 'ci_customeritems_ci_customeritems_name',
  'type' => 'relate',
  'source' => 'non-db',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_L_TITLE',
  'save' => true,
  'id_name' => 'ci_customeritems_ci_customeritemsci_customeritems_ida',
  'link' => 'ci_customeritems_ci_customeritems',
  'table' => 'ci_customeritems',
  'module' => 'CI_CustomerItems',
  'rname' => 'name',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_ci_customeritemsci_customeritems_ida"] = array (
  'name' => 'ci_customeritems_ci_customeritemsci_customeritems_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_ci_customeritems',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'left',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_R_TITLE',
);
$dictionary["CI_CustomerItems"]["fields"]["ci_customeritems_ci_customeritemsci_customeritems_ida"] = array (
  'name' => 'ci_customeritems_ci_customeritemsci_customeritems_ida',
  'type' => 'link',
  'relationship' => 'ci_customeritems_ci_customeritems',
  'source' => 'non-db',
  'reportable' => false,
  'side' => 'left',
  'vname' => 'LBL_CI_CUSTOMERITEMS_CI_CUSTOMERITEMS_FROM_CI_CUSTOMERITEMS_L_TITLE',
);

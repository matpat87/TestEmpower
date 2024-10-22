<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

// Call function in browser: <url>/index.php?module=TRI_TechnicalRequestItems&action=UpdateTRItemName
updateTRItemName();

function updateTRItemName()
{
  global $db, $app_list_strings;

  $db = DBManagerFactory::getInstance();
  $sql = "SELECT tri_technicalrequestitems.id FROM tri_technicalrequestitems WHERE tri_technicalrequestitems.deleted = 0";
  $result = $db->query($sql);

  while($row = $db->fetchByAssoc($result) ) {
    $trItemBean = BeanFactory::getBean('TRI_TechnicalRequestItems', $row['id']);

    if ($trItemBean && $trItemBean->id) {
      $trItemBean->name = array_search($trItemBean->name, $app_list_strings['distro_item_list']) ? array_search($trItemBean->name, $app_list_strings['distro_item_list']) : $trItemBean->name;
      $trItemBean->save();
    }
  }
}
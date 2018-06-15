<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetField.php');

class SugarWidgetSubPanelDetailViewLink extends SugarWidgetField
{
	function displayList(&$layout_def)
	{
		global $focus;
        
		$module = '';
		$record = '';

		if(isset($layout_def['varname']))
		{
			$key = strtoupper($layout_def['varname']);
		}
		else
		{
			$key = $this->_get_column_alias($layout_def);
			$key = strtoupper($key);
		}
		if (empty($layout_def['fields'][$key])) {
			return "";
		} else {
			$value = $layout_def['fields'][$key];
		}
			
		
		if(empty($layout_def['target_record_key']))
		{
			$record = $layout_def['fields']['ID'];
		}
		else
		{
			$record_key = strtoupper($layout_def['target_record_key']);
			$record = $layout_def['fields'][$record_key];
		}

		if(!empty($layout_def['target_module_key'])) { 
			if (!empty($layout_def['fields'][strtoupper($layout_def['target_module_key'])])) {
				$module=$layout_def['fields'][strtoupper($layout_def['target_module_key'])];
			}	
		}		
        
        if (empty($module)) {
			if(empty($layout_def['target_module']))
			{
				$module = $layout_def['module'];
			}
		else
			{
				$module = $layout_def['target_module'];
			}
		}
		
        //links to email module now need additional information.
        //this is to resolve the information about the target of the emails. necessitated by feature that allow
        //only on email record for the whole campaign.
        $parent='';       
        if (!empty($layout_def['parent_info'])) {
			if (!empty($focus)){
	            $parent="&parent_id=".$focus->id;
	            $parent.="&parent_module=".$focus->module_dir;
			}				
        } else {
            if(!empty($layout_def['parent_id'])) { 
                if (isset($layout_def['fields'][strtoupper($layout_def['parent_id'])])) {
                    $parent.="&parent_id=".$layout_def['fields'][strtoupper($layout_def['parent_id'])];
                }
            }        
            if(!empty($layout_def['parent_module'])) { 
                if (isset($layout_def['fields'][strtoupper($layout_def['parent_module'])])) {
                    $parent.="&parent_module=".$layout_def['fields'][strtoupper($layout_def['parent_module'])];
                }
            }        
        }
		$action = 'DetailView';
		$value = $layout_def['fields'][$key];
		global $current_user;
		if(  !empty($record) &&
			($layout_def['DetailView'] && !$layout_def['owner_module'] 
			||  $layout_def['DetailView'] && !ACLController::moduleSupportsACL($layout_def['owner_module']) 
			|| ACLController::checkAccess($layout_def['owner_module'], 'view', $layout_def['owner_id'] == $current_user->id))){
                if(!empty($parent)){
            return '<a href="index.php?module='.$module.'&action='.$action.'&record='.$record.$parent.'" >'."$value</a>";
                    }
                
                return "<a href='#' "
    			. " onMouseOver=\"javascript:subp_nav('".$module.$parent."', '".$record."', 'd', this);\" " 
                ." onFocus=\"javascript:subp_nav('".$module."', '".$record."', 'd', this);\">$value</a>";
		}else{
			return $value;
		}
		
	}
}

?>
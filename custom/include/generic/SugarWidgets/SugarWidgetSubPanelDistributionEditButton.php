<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/generic/SugarWidgets/SugarWidgetSubPanelEditButton.php');

class SugarWidgetSubPanelDistributionEditButton extends SugarWidgetSubPanelEditButton
{
	function displayList(&$layout_def)
	{
		global $app_strings;
        global $subpanel_item_count;
		$unique_id = $layout_def['subpanel_id']."_edit_".$subpanel_item_count; //bug 51512

        if ($layout_def['EditView']) {

            $relationship_name = '';
            if (!empty($layout_def['linked_field'])) {
                $relationship_name = $layout_def['linked_field'];
                $bean = BeanFactory::getBean($layout_def['module']);
                if (!empty($bean->field_defs[$relationship_name]['relationship'])) {
                    $relationship_name = $bean->field_defs[$relationship_name]['relationship'];
                }
            }

            $handler = 'subp_nav(\'DSBTN_Distribution\', \'' . $layout_def['fields']['DSBTN_DISTRIBUTION_ID_C'] . '\', \'e\', this';
            if (!empty($relationship_name)) {
                $handler .= ', \'' . $relationship_name . '\'';
            }
            $handler .= ');';

            return '<a href="#" onmouseover="' . $handler . '" onfocus="' . $handler .
                '" class="listViewTdToolsS1" id="' . $unique_id . '">' . $app_strings['LNK_EDIT'] . '</a>';
        }

        return '';
    }
}

?>
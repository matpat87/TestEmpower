<?php 

$relationshipsInfo = wfm_utils::getRelationshipsInfo($objectModule);
wfm_utils::wfm_log('flow_debug', '$relationshipsInfo=['.var_export($relationshipsInfo, true).']', __FILE__, __METHOD__, __LINE__);

$names = (isset($relationshipsInfo['names'])) ? $relationshipsInfo['names'] : null;
$relationships = (isset($relationshipsInfo['relationships'])) ? $relationshipsInfo['relationships'] : null;
$modules = (isset($relationshipsInfo['modules'])) ? $relationshipsInfo['modules'] : null;
$moduleLabels = (isset($relationshipsInfo['moduleLabels'])) ? $relationshipsInfo['moduleLabels'] : null;
$vnames = (isset($relationshipsInfo['vnames'])) ? $relationshipsInfo['vnames'] : null;
$labels = (isset($relationshipsInfo['labels'])) ? $relationshipsInfo['labels'] : null;

// Order 
$labels_lowercase = array_map('strtolower', (!empty($labels) ? $labels : array() ));
if (!empty($labels_lowercase)) {
	array_multisort($labels_lowercase, $names, $relationships, $modules, $moduleLabels, $vnames, $labels);
}

$relationshipsSelect = wfm_utils::generateHtmlRelationshipsSelect($labels, $names, $vnames, $relationships, $moduleLabels, $modules, $multiple);

// js Language Files
if ($translateFieldLabels) {
	wfm_utils::wfm_add_jsModLanguages($objectModule, true, true, $modules, $focus, $bean, $fieldsToBeRemoved, $translateFieldLabels, $rhs_key);
}

?>

<table border=0 width='100%'>
	<tbody>
		<tr>
			<td>
				<table>
					<tr>
						<td>
							<h4><?php echo $mod_strings['LBL_RELATIONSHIPS']; ?></h4>
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $relationshipsSelect; ?>
						</td>
					</tr>
					<tr>
						<td>
							<input type='button' title='<?php echo $mod_strings['LBL_ADD_RELATIONSHIPS']; ?>' class='button' name='relationships_button' value='<?php echo $mod_strings['LBL_ADD_RELATIONSHIPS']; ?>' onClick='createModifyObject_onClick_addRelationships();'>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>

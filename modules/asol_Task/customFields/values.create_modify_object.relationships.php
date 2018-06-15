<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', 'ENTRY', __FILE__);

global $mod_strings;

?>

<table id='relationshipsTable' class='edit view'>
	<tr>
		<th>
			<div align='left'>
				<?php echo $mod_strings['LBL_RELATIONSHIP_NAME']; ?>
			</div>
		</th>
		<th>
			<div align='left'>
				<?php echo $mod_strings['LBL_RELATIONSHIP_VALUE']; ?>
			</div>
		</th>
		<th>
			 <input type='hidden' id='uniqueRowIndexesForRelationships' value='0' />
		</th>
	</tr>
</table>

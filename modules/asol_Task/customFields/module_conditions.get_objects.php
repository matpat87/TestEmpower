<?php
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

wfm_utils::wfm_log('debug', "ENTRY", __FILE__);

global $mod_strings;

?>

<table id="conditions_Table" class="edit view conditions">

	<tr>

		<th nowrap="nowrap" scope="col">
			<div align="left" style="white-space: nowrap;">
			<?php echo $mod_strings['LBL_ASOL_LOGICAL_OPERATORS']; ?>
			</div>
		</th>
		
		<th nowrap="nowrap" scope="col">
			<div align="left" style="white-space: nowrap;">
			<?php echo $mod_strings['LBL_ASOL_DATABASE_FIELD']; ?>
			</div>
		</th>
		
		<th nowrap="nowrap" scope="col">
			<div align="left" style="white-space: nowrap;">
			<?php echo $mod_strings['LBL_ASOL_OLD_BEAN_NEW_BEAN_CHANGED']; ?>
			</div>
		</th>
		
		<th nowrap="nowrap" scope="col">
			<div align="left" style="white-space: nowrap;">
			<?php echo $mod_strings['LBL_IS_CHANGED']; ?>
			</div>
		</th>

		<th nowrap="nowrap" scope="col">
			<div align="left" style="white-space: nowrap;">
			<?php echo $mod_strings['LBL_ASOL_OPERATOR']; ?>
			</div>
		</th>

		<th nowrap="nowrap" scope="col">
			<div align="left" style="white-space: nowrap;">
			<?php echo $mod_strings['LBL_ASOL_FIRST_PARAMETER']; ?>
			</div>
		</th>

		<th nowrap="nowrap" scope="col">
			<div align="left" style="white-space: nowrap;">
			<?php echo $mod_strings['LBL_ASOL_SECOND_PARAMETER']; ?>
			</div>
		</th>
		
		<th>
			<div align='left'>
				<?php echo $mod_strings['LBL_ACV_FUNCTIONS']; ?>
			</div>
		</th>

		<th nowrap="nowrap" scope="col" colspan="2">
			<input type="hidden" id="uniqueRowIndexes" value="0">
		</th>

	</tr>
	
</table>
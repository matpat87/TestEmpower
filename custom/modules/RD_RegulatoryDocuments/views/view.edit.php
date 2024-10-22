<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once 'modules/RD_RegulatoryDocuments/views/view.edit.php';

class CustomRD_RegulatoryDocumentsViewEdit extends RD_RegulatoryDocumentsViewEdit
{
    public function display()
    {
        global $log;

        if(isset($this->bean->id)) {
			echo "
			<script>
				$(document).ready(function() {
					$(\"div[field='parent_name']\").parent().remove();
				});
			</script>";
        }
        parent::display();
    }
}
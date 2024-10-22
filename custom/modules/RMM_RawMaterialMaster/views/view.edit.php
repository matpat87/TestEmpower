<?php

require_once 'include/MVC/View/views/view.edit.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class RMM_RawMaterialMasterViewEdit extends ViewEdit
{
    public function preDisplay()
    {
        parent::preDisplay();
    }

    public function display()
    {
        if (! isset($this->bean->id)) {
            echo "
				<script>
					$(document).ready(function() {
                        $(\"input#name\")
                            .removeClass('custom-readonly')
                            .prop('readonly', false);
					});
				</script>
			
			";
        }
        
        parent::display();
    }
}
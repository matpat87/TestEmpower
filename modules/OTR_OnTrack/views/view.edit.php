<?php

require_once 'include/MVC/View/views/view.edit.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class OTR_OnTrackViewEdit extends ViewEdit
{
  function display()
  {
    parent::display();

    echo '<style>
		#closed_date_c_trigger {
            visibility: hidden;
        }	
    </style>';
  }
}
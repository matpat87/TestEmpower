<?php

require_once('include/MVC/View/views/view.detail.php');


class COMP_CompetitorViewDetail extends ViewDetail {

	function __construct(){
        parent::__construct();
    }

    function preDisplay()
    {
        global $log;
        
        
        parent::preDisplay();
    }

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function COMP_CompetitorViewDetail(){
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if(isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        }
        else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }


	function display() 
    {
        global $log, $current_user, $app_list_strings;
        
        $competitionLink ="<a href='index.php?module=MKT_Markets&amp;action=DetailView&amp;record={$this->bean->competitor}'><span id='competitor' class='sugar_field' data-id-value='{$this->bean->competitor}'>{$this->bean->competition}</span></a>";

        // $this->ss->assign('competitionLink', $competitionLink);
        parent::display();
        
	}

    
}

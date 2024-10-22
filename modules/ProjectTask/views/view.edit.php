<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/views/view.edit.php');

class ProjectTaskViewEdit extends ViewEdit {

 	function __construct(){
 		parent::__construct();
 	}

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function ProjectTaskViewEdit(){
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
        if ($this->bean->parent_id || $_REQUEST['parent_id']) {
            $parentId = $_REQUEST['parent_id'] ?? $this->bean->parent_id;
            $parentType = $_REQUEST['parent_type'] ?? $this->bean->parent_type;
            $parentBean = BeanFactory::getBean($parentType, $parentId);
            $parentName = $parentBean->name;
            $this->bean->parent_name = $parentName;
        }
        
        parent::display();
    }
}

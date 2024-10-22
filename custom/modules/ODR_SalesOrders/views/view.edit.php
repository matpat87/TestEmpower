<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('custom/modules/AOS_Products/helper/ProductHelper.php');

class ODR_SalesOrdersViewEdit extends ViewEdit {
    function __construct(){
        parent::__construct();
    }

    
    public function preDisplay(){
        /*$metadataFile = $this->getMetaDataFile();
        $this->ev = $this->getEditView();
        $this->ev->ss =& $this->ss;
        $this->ev->setup($this->module, $this->bean, $metadataFile, 'custom/modules/ODR_SalesOrders/EditView.tpl');*/
        parent::preDisplay();
    }
    

    function display() {
        parent::display();
    }
}

?>

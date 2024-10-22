<?php

require_once 'include/MVC/View/views/view.edit.php';
require_once('custom/modules/VI_VendorIssues/helpers/VI_VendorIssuesHelper.php');

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class VI_VendorIssuesViewEdit extends ViewEdit
{
    public function preDisplay()
    {
        parent::preDisplay();
    }

    public function display()
    {
        global $current_user;

        $this->bean->vi_vendorissues_number = (! isset($this->bean->id)) ? 'TBD' : $this->bean->vi_vendorissues_number;

        if(empty($this->bean->created_by_name)){
            $this->bean->created_by_name = $current_user->full_name;
        }
        
        $this->_addHeaders();
        parent::display();
    }

    private function _addHeaders(){
        echo <<<EOF
            <script type="text/javascript">
                $(document).ready(function(){
                    var panel_bg_color = 'var(--custom-panel-bg)';

                    $("div[field='product_details_non_db']")
                        .prev()
                        .removeClass('col-sm-2')
                        .addClass('col-sm-12').addClass('col-md-12').addClass('col-lg-12')
                        .css('background-color', panel_bg_color).css('color', '#FFF').css('margin-top', '15px').css('padding', '0px 0px 8px 10px').parent().css('padding-left', '0px');

                    $("div[field='product_details_non_db']").addClass('hidden');
                });
            </script>
EOF;
    }
}
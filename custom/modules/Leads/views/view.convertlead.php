<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point'); 

    require_once("include/EditView/EditView2.php");
    require_once("include/upload_file.php");
    require_once("modules/Leads/views/view.convertlead.php");
    require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

    class CustomViewConvertLead extends ViewConvertLead
    {
        function display()
        {
           
            parent::display();
            echo "
            <script> 
                $(document).ready(function() {
                   $('#Opportunitiesavg_sell_price_c, #Opportunitiesamount').val('$0.00')
                   $('#Opportunitiesprobability_prcnt_c')
                   .attr('readonly', 'readonly')
                   .css('background', '#f8f8f8')
                   .css('border', '1px solid #e2e7eb')
                   .css('cursor', 'not-allowed');
                   
                });
            </script>
            <script src='custom/modules/Opportunities/js/custom-edit.js'></script>
            <script src='custom/modules/Contacts/js/custom-edit.js'></script>
            
            
            ";

        }
    }
?>
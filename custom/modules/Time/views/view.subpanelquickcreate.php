<?php
require_once('include/EditView/SubpanelQuickCreate.php');

class TimeSubpanelQuickCreate extends SubpanelQuickCreate
{
    public function process($module) {
        global $log;
        
        $_REQUEST['return_action'] = 'DetailView';
        // Run custom submit script when Time Created is via Ontrack Time subpanel QuickCreate
        if ($_REQUEST['return_module'] == 'OTR_OnTrack' && $_REQUEST['action'] == 'SubpanelCreates') {
        
            echo "<script>
                $(document).ready( function() {
                    let timeSubmitBtn = $('input[type=\"submit\"][name=\"Time_subpanel_save_button\"]');
                    let actualHrsStr = parseFloat($('div[field=actual_hours_worked_c]').text().trim());
                   
                    timeSubmitBtn
                        .removeAttr('onclick')
                        .on('click', (e) => {
                            e.preventDefault();

                            var _form = document.getElementById('form_SubpanelQuickCreate_Time');
                            _form.action.value='Save';

                            var hrsInput = $('input#time').val();
                            
                            if ( isNaN(parseFloat(hrsInput)) ) {
                                // Not a number
                                hrsInput = 0.00 + actualHrsStr;
                            } else {
                                hrsInput = parseFloat(hrsInput) + actualHrsStr
                            }
                            
                            var newHrsString = hrsInput.toFixed(2).toString();

                            document.getElementById('form_SubpanelQuickCreate_Time'); 
                            disableOnUnloadEditView();

                            if(check_form('form_SubpanelQuickCreate_Time')) {
                                $('div[field=actual_hours_worked_c] span#actual_hours_worked_c').text(newHrsString);
                                return SUGAR.subpanelUtils.inlineSave(_form.id, 'Time_subpanel_save_button');
                            }
                            return false;
                        });
                })
                 
            </script>";
        }
        parent::process("Time");
    }
}

?>


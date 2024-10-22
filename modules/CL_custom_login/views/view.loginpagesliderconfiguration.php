<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
require_once('include/MVC/View/SugarView.php');

class CL_custom_loginViewLoginpagesliderconfiguration extends SugarView {

    function display() {
        //------------------------checking licence configuration status------------------------------
        require_once('modules/bc_Quote_Category/login_plugin.php');
        $checkLoginSubscription = validateLoginSubscription();
        if (!$checkLoginSubscription['success']) {
            if (!empty($checkLoginSubscription['message'])) {
                echo '<div style="color: #F11147;text-align: center;background: #FAD7EC;padding: 10px;margin: 3% auto;width: 70%;top: 50%;left: 0;right: 0;border: 1px solid #F8B3CC;font-size : 14px;">' . $checkLoginSubscription['message'] . '</div>';
            }
        } else { //--------- module enabled--------
            if (!empty($checkLoginSubscription['message'])) {
                echo '<div style="color: #f11147;font-size: 14px;left: 0;text-align: center;top: 50%;">' . $checkLoginSubscription['message'] . '</div>';
            }
            global $db, $current_user;
            $current_theme = $current_user->getPreference('user_theme');
            require_once 'modules/CL_custom_login/slider_function.php';
            parent::display();
            $image_count = getSliderConfiguration();
            $html = '';
            $html .= "<form action='' method='post' onsubmit='return validationNumber();'>
                <input type='hidden' name='module' value='CL_custom_login'>
                <input type='hidden' name='action' value='storeConfigurationSetting'>
                <h2>Image Slider Configuration</h2>";
            if ($image_count != '' && $_REQUEST['showmsg'] == true) {
                $html .= " <p align='center'><label id='label' align='center' style='color:green;font-weight:bold;font-size:14px;'>Updated successfully</label></p>";
            }
            $html .= "  <table class=\"actionsContainer\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                <tbody>
                <tr>
                <td>
		  <br/>      <input title=\"Save [Alt+S]\" accesskey=\"S\" class=\"button primary\" name=\"submit_conf\" value=\" Save \" type=\"submit\">
		        &nbsp;<input title=\"Return To Admin\" onclick=\"document.location.href='index.php?module=Administration&amp;action=index'\" class=\"button\" name=\"cancel\" value=\" Return To Admin \" type=\"button\">
                </td>
	            </tr>
	            </tbody></table>
                <table class=\"edit view\" style='margin:2px;' cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                <tbody>
                <tr>";
            if ($current_theme == 'SuiteP') {
                $html .= "   <td scope=\"row\" valign=\"top\" width=\"25%\"><div style='margin:10px'>No of images to be displayed on image slider:</div></td>";
            } else {
                $html .= "   <td scope=\"row\" valign=\"top\" width=\"20%\"><div style='margin:10px'>No of images to be displayed on image slider:</div></td>";
            }
            if ($current_theme == 'SuiteR') {
                $html.= " <td valign=\"top\" width=\"30%\" height=\"60px\" >";
            } else {
                $html.= " <td valign=\"top\" width=\"30%\" >";
            }
            $html.="	<div style='margin:10px'>  <input type='text' name='image_count'  id='image_count_text' style=' width:40%;' value='{$image_count}'>
                <input title=\"Clear [Alt+S]\" class=\"button primary\" name=\"clear\" value=\" Clear \" type=\"button\" onclick=\" clear_input();\"> </div>
    	        </td>
    	        <td scope=\"row\" width=\"17%\"></td>
                <td></td>
                </tr>
                </tbody></table>
                <div style=\"padding-top: 2px;\">
                <input title=\"Save [Alt+S]\" class=\"button primary\" name=\"submit_conf\" value=\" Save \" type=\"submit\">
		        &nbsp;<input title=\"Return To Admin\" onclick=\"document.location.href='index.php?module=Administration&amp;action=index'\" class=\"button\" name=\"cancel\" value=\" Return To Admin \" type=\"button\">
                </div>
                </form>";
            echo $html;
        }
    }

}
?>
<script type="text/javascript">
    function validationNumber() {
        var reg = new RegExp('^[0-9]+$');
        var textID = document.getElementById('image_count_text').value;

        if (textID && !reg.test(textID) && typeof reg != 'undefined') {
            alert("Please enter only positive integer number.");
            return false;
        }
        if (textID != '' && textID <= 0) {
            alert("Allowed only greater than 0.");
            return false;
        }
        alert('Configuration saved successfully');
    }
    function clear_input() {
        $('#image_count_text').val('');
    }
</script>

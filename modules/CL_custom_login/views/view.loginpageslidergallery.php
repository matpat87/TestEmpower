<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
require_once('include/MVC/View/SugarView.php');

class CL_custom_loginViewLoginpageslidergallery extends SugarView {

    function display() {
        //-----------------------checking sugar and include js if required----------------------------
        global $current_user;
        $current_theme = $current_user->getPreference('user_theme');
        $current_subTheme = $current_user->getPreference('subtheme');
        if ($current_theme == "SuiteP") {
            if ($current_subTheme == "Night") {
                $file = "custom/themes/{$current_theme}/css/quoteNight.css";
                echo "<link href='{$file}' rel='stylesheet'>";
            }
        }
        if ($current_user->getPreference('suitecrm_version') != '') {
            $is_sugar = $current_user->getPreference('suitecrm_version');
        } else {
            $is_sugar = '';
            echo "<script src='modules/CL_custom_login/loginSlider/js/jquery.js'></script>";
        }
        //------------------------checking licence configuration status------------------------------
        require_once('modules/bc_Quote_Category/login_plugin.php');
        $checkLoginSubscription = validateLoginSubscription();
        if (!$checkLoginSubscription['success']) {
            if (!empty($checkLoginSubscription['message'])) {
                echo '<div style="color: #F11147;text-align: center;background: #FAD7EC;padding: 10px;margin: 3% auto;width: 70%;top: 50%;left: 0;right: 0;border: 1px solid #F8B3CC;font-size : 14px;">' . $checkLoginSubscription['message'] . '</div>';
            }
        } else { //--------- module enabled--------
            
            require_once 'modules/CL_custom_login/slider_function.php';
            parent::display();
            global $current_user, $db, $sugar_config;
            $uploadDir = $sugar_config['dls_dir_path'];
            $current_listofImage = getImageListConfiguration();
            $fileNameArrayCount = $current_listofImage != 0 ? $current_listofImage : 1;


            $showMsg = "display:none";
            if (isset($_REQUEST['displayMsg']) ? $_REQUEST['displayMsg'] : '') {
                $showMsg = '';
            }

            $html = '';
            $html .= "<br/><h2>Upload Slider Images</h2><span style='color:red; $showMsg'><li>Please upload images with following extensions only ('gif', 'GIF', 'jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG').</li>
                                                   <li>Upload file size should be at max 2 MB.</li>
                                                   <li>Image dimension should be greater than 1000(width) X 700(height). </li>
                                                   </span>";
            $html .= "<span style='position: relative;left: 40%;color:red;$showMsg'><b>Image upload failed, please make sure above conditions are met.</b></span><br><br>";
            $html .= "<table class=\"edit view\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                   <tbody>
                     <tr><td scope=\"row\" colspan=\"4\" align=\"left\"><input type='button' id='btn_add_image' onclick='addImage({$fileNameArrayCount})' value='Add New Image' style='margin-top:5px;margin-bottom:5px !important;' /></td></tr>
                    <tr>
    	            <td scope=\"row\" colspan=\"4\" align=\"left\">
                    <div class='dashletPanelMenu wizard'>
                    <div class='bd'>
		            <div class='screen'>";

            $cl_custom = new CL_custom_login();
            $cl_custom_result = $cl_custom->get_list("date_modified", "");

            if ($fileNameArrayCount > 0) {
                $class = '';
                for ($i = 1; $i <= $fileNameArrayCount; $i++) {
                    if (($i % 6) == 0) {
                        $class = 'last';
                    } else {
                        $class = '';
                    }

                    $file = array();
                    $f = 0;


                    if (count($cl_custom_result['list']) != '0') {

                        foreach ($cl_custom_result['list'] as $key => $value) {
                            array_push($file, $value->id . '.' . $value->image_type);
                        }
                    } else {
                        array_push($file, 'modules/CL_custom_login/loginSlider/images/no-image.png');
                    }
                    if (!array_key_exists($i - 1, $file)) {

                        for ($counter = $f; $counter <= $i - 1; $counter++) {
                            array_push($file, 'modules/CL_custom_login/loginSlider/images/no-image.png');
                        }
                    }

                    $uniqe_id = create_guid();
                    if (SugarThemeRegistry::current() == 'SuiteP') {
                        $html .= "<div class='login-img-uploading {$class}' style='width:18.6%' name='$uniqe_id'>";
                    } else {
                        $html .= "<div class='login-img-uploading {$class}' style='width:14.6%' name='$uniqe_id'>";
                    }
                    $html .= "<form action='' method='post' enctype='multipart/form-data'>";
                    $html .= "<input type='hidden' name='module' value='CL_custom_login'>";
                    $html .= "<input type='hidden' name='action' value='uploadImage'>";
                    if ($file[$i - 1] == 'modules/CL_custom_login/loginSlider/images/no-image.png') {
                        $html .= "<p > <img src='{$file[$i - 1]}' name='img_{$i}' height='116px' width='110px'>";
                        $html.= "<script>$('[name=\"{$uniqe_id}\"]').removeClass('img-uploaded');</script>";
                        $html.= "<script>$('[name=\"{$uniqe_id}\"]').find('p').addClass('no-img-uploaded');</script>";
                    } else {
                        $html .= "<p > <img src='{$uploadDir}{$file[$i - 1]}' name='img_{$i}' height='140px' width='110px'>";
                        $html.= "<script> $('[name=\"{$uniqe_id}\"]').addClass('img-uploaded');</script>";
                        $html.= "<script>$('[name=\"{$uniqe_id}\"]').find('p').removeClass('no-img-uploaded');</script>";
                    }
                    isset($_REQUEST['unid']) ? $uniq_id = $_REQUEST['unid'] : $uniq_id = '';
                    $html .= "</p>
                        <div class='btm-block'><p class='uploader'>";
                    if ($file[$i - 1] == 'modules/CL_custom_login/loginSlider/images/no-image.png') {
                        $html.="<input style='width: 99%;' required='true' type='file' name='file' /></p><div class='bottm-btn'> "
                                . "<input type='submit' name='submit' value='Upload' />  <input type='hidden' id='hidden_noimage{$i}' value='{$file[$i - 1]}' />";
                    } else {
                        $html.="<div class='bottm-btn'> <input type='hidden' name='uploadImage_code' value='{$uniq_id}' />
                                <input type='button' value='Remove Image' onclick='if(confirm(\"Are you sure want to remove this image ? \")){ removeImage(\"{$file[$i - 1]}\")}'/>
                                <input type='hidden' id='hidden_noimage{$i}' value='{$file[$i - 1]}' />";
                    }
                    if ($fileNameArrayCount > 1) {
                        $html.= "<input type='button' title='Remove Image Section' class='remove-btn' id='removeBlock' onclick='removeblock(\"{$uniqe_id}\",\"{$i}\",\"{$file[$i - 1]}\",\"{$fileNameArrayCount}\")' value='' />";
                    }
                    $html.="</div>
                        </div> ";
                    $html .= "</form>";
                    $html .= "</div>";
                }
            } else {
                $html .= "<span>Please configure number of images to display in slider from <a href='index.php?module=CL_custom_login&action=loginPageSliderConfiguration'>here</a>.</span> <br /><br />";
            }
            $html .= "
                 </td>
                </tr>
                </tbody></table>";
            //   $html .= "</div></div></div>";
            echo $html;

            $html = "<br/><form action='' method='post' onsubmit='return validationNumber();'>
                <input type='hidden' name='module' value='CL_custom_login'>
                <input type='hidden' name='action' value='storeConfigurationSetting'>
                <h2>Image Slider Configuration</h2>";
            $image_count = getSliderConfiguration();
            
            $html .= "  <table class=\"actionsContainer\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
                <tbody>
                <tr>
                <td>
		  <br/> <br/>
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
<style type="text/css">
    .login-img-uploading {
        display: inline-block;
        border: 1px solid #ccc;
        margin: 0px 1% 2% 0;
        padding: 0.5%;
        position: relative;
    }

    .login-img-uploading.last {
        margin-right: 0px;
    }

    .login-img-uploading img {
        width: 100%;
    }

    .login-img-uploading .btm-block {
        border-top: 1px solid #ccc;
        padding: 5px;
    }

    .login-img-uploading .btm-block .bottm-btn {
        margin-top: 10px;
    }

    .login-img-uploading .btm-block .bottm-btn input {
        padding: 3px 16px 2px 17px;
    }

    .img-uploaded .btm-block {
        padding-top: 11px;
    }

    .no-img-uploaded{padding-bottom: 5px;}
    input.remove-btn{background: url('modules/CL_custom_login/loginSlider/images/btn_window_close.gif') no-repeat !important; position: absolute; right: 0; top: 0; border: none; width: 15px; height: 15px; padding: 0 !important;}

</style>
<script type="text/javascript">
    function addImage(i) {
        i++;
        var array_status = new Array();
        for (var count = 1; count < i; count++) {
            array_status.push($('#hidden_noimage' + count).val());
        }

        function include(arr, obj) {
            for (var i = 0; i < arr.length; i++) {
                if (arr[i] == obj)
                    return true;
            }
        }
        if (include(array_status, 'modules/CL_custom_login/loginSlider/images/no-image.png') == true) {
            alert('Please upload image on empty section.');
        }
        else {
            $.ajax({
                url: "index.php?module=CL_custom_login&action=imagelistupdate",
                type: "GET",
                data: {count: i},
                success: function () {
                    location.assign('index.php?module=CL_custom_login&action=loginPageSliderGallery');
                },
                error: function (msg)
                {
                    alert("Image Block Error  :  " + msg);
                }
            });
        }
    }
    function removeImage(image_id) {
        $.ajax({
            url: "index.php",
            type: "POST",
            data: {module: 'CL_custom_login', action: 'removeImage', image_id: image_id},
            success: function (data)
            {
                location.assign('index.php?module=CL_custom_login&action=loginPageSliderGallery');
            },
            error: function (msg)
            {
                alert("Remove Image Error  :  " + msg);
            }
        });

    }
    function removeblock(uid, i, file, count) {
        var confirmMsg = '';
        if (file == 'modules/CL_custom_login/loginSlider/images/no-image.png') {
            confirmMsg = 'Are you sure want to remove this section ?';
        }
        else {
            confirmMsg = 'Are you sure want to remove this section with image ?';
        }
        if (confirm(confirmMsg)) {
            $.ajax({
                url: "index.php",
                type: "POST",
                data: {module: 'CL_custom_login', action: 'removeImageBlock', image_id: file, imagecount: count},
                success: function (data)
                {
                    $('[name="' + uid + '"]').hide();
                    $('[name="' + uid + '"]').removeClass();
                    $('[name="' + uid + '"]').html('');
                    location.assign('index.php?module=CL_custom_login&action=loginPageSliderGallery');
                },
                error: function (msg)
                {
                    alert("Remove Block Error  :  " + msg);
                }
            });
        }
    }

    function validationNumber() {
        var reg = new RegExp('^[0-9]+$');
        var textID = document.getElementById('image_count_text').value;
        var lengthOfImage = $('.login-img-uploading').length;
        if (textID && !reg.test(textID) && typeof reg != 'undefined') {
            alert("Please enter only positive integer number.");
            return false;
        }
        else if (textID != '' && textID <= 0) {
            alert("Allowed only greater than 0.");
            return false;
        } 
        else if (textID != '' && textID > lengthOfImage) {
            alert("Allowed only less than or equal to "+lengthOfImage+".");
            return false;
        } 
        alert('Configuration saved successfully');
    }
    function clear_input() {
        $('#image_count_text').val('');
    }

</script>

<?PHP

require_once 'include/MVC/Controller/SugarController.php';

class CL_custom_loginController extends SugarController {

    public function action_loginPageSliderGallery() {
        global $current_user, $db;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'loginpageslidergallery';
        $GLOBALS['view'] = $this->view;
    }

    public function action_editview() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'noaccess';
        $GLOBALS['view'] = $this->view;
    }

    public function action_listview() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'noaccess';
        $GLOBALS['view'] = $this->view;
    }

    public function action_detailview() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'noaccess';
        $GLOBALS['view'] = $this->view;
    }

    public function action_uploadImage() {
        global $sugar_config, $current_user;
        require_once 'modules/CL_custom_login/slider_function.php';
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }

        $allowedExts = $sugar_config['allowedExts'];
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
        $directory = $sugar_config['dls_dir_path'];
        list($width_uploadImage, $height_uploadImage) = getimagesize($_FILES["file"]["tmp_name"]);

        $displayMsg = false;
        $validImageTypes = $sugar_config['validImageTypes'];
        $imgSize = getConvertedUploadImageSizeInMB($_FILES["file"]["size"]);
        if (isset($_REQUEST['submit'])) {
            if (in_array($_FILES["file"]["type"], $validImageTypes) &&
                    $imgSize <= 2 &&
                    in_array($extension, $allowedExts) &&
                    $width_uploadImage >= 1000 &&
                    $height_uploadImage >= 700
            ) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {
                    $custom_login = new CL_custom_login();
                    $custom_login->name = 'new';
                    $custom_login->save();
                    $cl_custom_result = $custom_login->get_list("", "");
                    foreach ($cl_custom_result['list'] as $key => $value) {
                        if ($value->name == 'new') {
                            $custom_id = $value->id;
                        }
                    }
                    $custom_login->retrieve($custom_id);
                    $custom_login->name = $custom_id;
                    $custom_login->image_type = $extension;
                    $custom_login->save();
                    move_uploaded_file($_FILES["file"]["tmp_name"], $directory . $custom_id . '.' . $extension);
                }
            } else {
                $displayMsg = true;
            }
        }
        header("Location:index.php?module=CL_custom_login&action=loginPageSliderGallery&displayMsg=" . $displayMsg . "&unid=" . $custom_id);
        exit;
    }

    public function action_loginPageSliderConfiguration() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'loginPageSliderConfiguration';
        $GLOBALS['view'] = $this->view;
    }

    public function action_storeConfigurationSetting() {
        $oAdministration = new Administration();
        $oAdministration->retrieveSettings('image_slider_conf');
        $oAdministration->saveSetting("image_slider_conf", "image_count", $_REQUEST['image_count']);
        header("Location:index.php?module=Administration&action=index");
        exit;
    }

    public function action_imagelistupdate() {
        $oAdministration = new Administration();
        $oAdministration->retrieveSettings('upload_image_list');
        $oAdministration->saveSetting("upload_image_list", "imagelist_count", $_REQUEST['count']);
        exit;
    }

    public function action_removeImage() {
        global $sugar_config;
        $image_id_withExt = $_REQUEST['image_id'];
        $rem_extension = explode('.', $image_id_withExt);
        $image_id = $rem_extension[0];
        $cl_custom = new CL_custom_login();
        $cl_custom->retrieve($image_id);
        $cl_custom->deleted = 1;
        $cl_custom->save();
        $image_full_path = $sugar_config['dls_dir_path'] . '' . $image_id_withExt;
        unlink($image_full_path);
        exit;
    }

    public function action_removeImageBlock() {
        global $sugar_config;
        $image_id_withExt = $_REQUEST['image_id'];
        $rem_extension = explode('.', $image_id_withExt);
        $image_id = $rem_extension[0];
        $c = $_REQUEST['imagecount'];
        $cl_custom = new CL_custom_login();
        $count = $c - 1;
        $removeBlock = true;
        if ($image_id != 'modules/CL_custom_login/loginSlider/images/no-image.png') {
            $removeBlock = false;
            $cl_custom->retrieve($image_id);
            $cl_custom->deleted = 1;
            $extention = $cl_custom->image_type;
            $cl_custom->save();

            $image_full_path = $sugar_config['dls_dir_path'] . $image_id_withExt;
            unlink($image_full_path);
        }
        $oAdministration = new Administration();
        $oAdministration->retrieveSettings('upload_image_list');
        $oAdministration->saveSetting("upload_image_list", "imagelist_count", $count);
        exit;
    }

}

?>

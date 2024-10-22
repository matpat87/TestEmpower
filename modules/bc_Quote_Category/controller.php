
<?PHP

class bc_Quote_CategoryController extends SugarController {

    //----------------------------for licence configuration-------------------------------------------------------------------
    public function action_login_licence_config() {
        global $current_user;
        if (is_admin($current_user)) {
            $this->view = "LoginConfiguration";
            $GLOBALS['view'] = $this->view;
        } else {
            $this->view = "noaccess";
            $GLOBALS['view'] = $this->view;
        }
    }

    function action_validateLicence() {
        require_once('modules/bc_Quote_Category/login_plugin.php');
        $key = $_REQUEST['k'];
        $CheckResult = checkPluginLicence($key);
        if ($CheckResult) {
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    function action_enableDisableLogin() {
        require_once('modules/Administration/Administration.php');
        $enabled = $_REQUEST['enabled'];
        $administrationObj = new Administration();
        $administrationObj->retrieveSettings('LoginPlugin');
        switch ($_REQUEST['enabled']) {
            case '1':
                $administrationObj->saveSetting("LoginPlugin", "ModuleEnabled", 1);
                $administrationObj->saveSetting("LoginPlugin", "LastValidationMsg", "");
                break;
            case '0':
                $administrationObj->saveSetting("LoginPlugin", "ModuleEnabled", 0);
                $administrationObj->saveSetting("LoginPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
                break;
            default:
                $administrationObj->saveSetting("LoginPlugin", "ModuleEnabled", 0);
                $administrationObj->saveSetting("LoginPlugin", "LastValidationMsg", "This module is disabled, please contact Administrator.");
        }
    }

    //-----------------------------------------------------------------------------------------------------------------------------------

    public function action_loginquote() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'loginquote';
        $GLOBALS['view'] = $this->view;
    }

    public function action_loginquotedisplay() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'loginquotedisplay';
        $GLOBALS['view'] = $this->view;
    }

    public function action_loginquotecategory() {
        global $current_user;
        if (!is_admin($current_user)) {
            sugar_die($GLOBALS['app_strings']['ERR_NOT_ADMIN']);
        }
        $this->view = 'loginquotecategory';
        $GLOBALS['view'] = $this->view;
    }

    public function action_savecat() {
        global $db;

        $id = json_decode(html_entity_decode($_REQUEST['id']));

        if (count($id) > 0) {
            $quote_category = new bc_Quote_Category();
            $fe = $quote_category->get_list("", "");

            foreach ($fe['list'] as $key => $value) {
                if ($value->description == '1') {
                    $value->description = 'NULL';
                    $value->save();
                }
            }
            foreach ($id as $data) {
                $quote_category->retrieve($data);
                $quote_category->description = 1;
                $quote_category->save();
                echo "1";
            }
        } else {
            $quote_category = new bc_Quote_Category();
            $fe = $quote_category->get_list("", "");

            foreach ($fe['list'] as $key => $value) {
                if ($value->description == '1') {
                    $value->description = 'NULL';
                    $value->save();
                }
            }
            echo "0";
        }

        exit;
    }

    public function action_savenewquote() {

        $quote = trim($_REQUEST['name'], " ");
        $quote_id = $_REQUEST['id'];
        if ($quote != '') {
            $bquote = new bc_Quote();
            $bquote->description = $quote;
            $bquote->save();
            // set relationship for newly created quote-------------------------
            $new_id = $bquote->id;
            $quotecat = new bc_Quote_Category();
            $quotecat->retrieve($quote_id);
            $quotecat->get_linked_beans('bc_quote_category_bc_quote', 'bc_Quote');
            $quotecat->bc_quote_category_bc_quote->add($new_id);
        }
        exit;
    }

    public function action_savenewcategory() {
        global $db;
        $name = trim($_REQUEST['name'], " ");
        $quote_category = new bc_Quote_Category();
        $quote_category_result = $quote_category->get_list("", "");
        $check = '';
        foreach ($quote_category_result['list'] as $key => $value) {
            if ($value->name == $name) {
                $check = $value->name;
            }
        }

        if (strtolower(trim($check)) == strtolower(trim($name)) && $check != '') {
            echo "not";
        } else {

            if ($name != '') {

                $quote_category->name = $name;
                $quote_category->save();
            }
        }
        exit;
    }

    public function action_delete_quote() {

        $data = $_REQUEST['del'];
        $quote = new bc_Quote();
        $quote->retrieve($data);
        $quote->deleted = 1;
        $quote->save();
        $quote->load_relationship('bc_quote_category_bc_quote');
        $quote->bc_quote_category_bc_quote->delete($quote->id);

        exit;
    }

    public function action_delete_category() {
        global $db;
        $data = $_REQUEST['delc'];

        $quote_category = new bc_Quote_Category();
        $quote_category->retrieve($data);
        $quote_category->load_relationship('bc_quote_category_bc_quote');
        //  $quote_category->bc_quote_category_bc_quote->delete($quote_category->id);
        foreach ($quote_category->bc_quote_category_bc_quote->getBeans() as $qu) {
            $quote = new bc_Quote();
            $quote->retrieve($qu->id);
            $quote->deleted = 1;
            $quote->save();
        }
        $quote_category->deleted = 1;
        $quote_category->save();

        exit;
    }

    public function action_update_quote() {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $quote = new bc_Quote();
        $quote->retrieve($id);
        $quote->description = $name;
        $quote->save();
        exit;
    }

    public function action_update_category() {
        $id = $_REQUEST['id'];
        global $db;
        $name = trim($_REQUEST['name'], " ");

        $quote_category = new bc_Quote_Category();
        $quote_category_result = $quote_category->get_list("", "");
        $check = '';
        foreach ($quote_category_result['list'] as $key => $value) {
            if ($value->name == $name) {
                $check = $value->name;
            }
        }

        if (strtolower(trim($check)) == strtolower(trim($name)) && $check != '') {
            echo "not";
        } else {
            $quote_category->retrieve($id);
            $quote_category->name = $name;
            $quote_category->save();
        }
        exit;
    }

}
?>



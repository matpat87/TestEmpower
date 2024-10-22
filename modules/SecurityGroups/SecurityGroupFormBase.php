<?php

require_once('custom/modules/SecurityGroups/helpers/SecurityGroupHelper.php');

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class SecurityGroupFormBase
{
    protected $db = null;

    public function __construct()
    {
        $this->db = DBManagerFactory::getInstance();
    }

    public function handleSave($prefix, $redirect=true, $useRequired=false)
    {
        require_once('include/formbase.php');

        $focus = new SecurityGroup();

        if ($useRequired && !checkRequired($prefix, array_keys($focus->required_fields))) {
            return null;
        }

        if (isset($GLOBALS['check_notify'])) {
            $check_notify = $GLOBALS['check_notify'];
        } else {
            $check_notify = false;
        }

        $focus = populateFromPost($prefix, $focus);

        $responseData = SecurityGroupHelper::handleDuplicateCheck($_POST, $prefix);

        if ($responseData['data']['isDuplicate']) {
            echo "<p>Data entered is flagged as duplicate! <a href='/index.php?module=SecurityGroups&action=DetailView&record={$responseData['data']['duplicateRecordId']}'>Click here to redirect to original record</a></p>";
            return null;
        }

        if (!$focus->ACLAccess('Save')) {
            ACLController::displayNoAccess(true);
            sugar_cleanup(true);
        }

        $focus->save($check_notify);
        $return_id = $focus->id;

        $GLOBALS['log']->debug("Saved record with id of ".$return_id);


        if (!empty($_POST['is_ajax_call']) && $_POST['is_ajax_call'] == '1') {
            $json = getJSONobj();
            echo $json->encode(array('status' => 'success',
                'get' => ''));
            $trackerManager = TrackerManager::getInstance();
            $timeStamp = TimeDate::getInstance()->nowDb();
            if ($monitor = $trackerManager->getMonitor('tracker')) {
                $monitor->setValue('action', 'detailview');
                $monitor->setValue('user_id', $GLOBALS['current_user']->id);
                $monitor->setValue('module_name', 'SecurityGroups');
                $monitor->setValue('date_modified', $timeStamp);
                $monitor->setValue('visible', 1);

                if (!empty($this->bean->id)) {
                    $monitor->setValue('item_id', $return_id);
                    $monitor->setValue('item_summary', $focus->get_summary_text());
                }
                $trackerManager->saveMonitor($monitor, true, true);
            }
            return null;
        }

        if (isset($_POST['popup']) && $_POST['popup'] == 'true') {
            $urlData = array("query" => true, "name" => $focus->name, "module" => 'SecurityGroups', 'action' => 'Popup');
            if (!empty($_POST['return_module'])) {
                $urlData['module'] = $_POST['return_module'];
            }
            if (!empty($_POST['return_action'])) {
                $urlData['action'] = $_POST['return_action'];
            }
            foreach (array('return_id', 'popup', 'create', 'to_pdf') as $var) {
                if (!empty($_POST[$var])) {
                    $urlData[$var] = $_POST[$var];
                }
            }
            header("Location: index.php?".http_build_query($urlData));
            return;
        }

        if ($redirect) {
            handleRedirect($return_id, 'SecurityGroups');
        } else {
            return $focus;
        }
    }
}
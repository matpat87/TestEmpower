<?php

require_once('include/MVC/View/views/view.list.php');
require_once 'custom/modules/RRQ_RegulatoryRequests/includes/CustomRRQ_RegulatoryRequestsListViewSmarty.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class RRQ_RegulatoryRequestsViewList extends ViewList
{
    function RRQ_RegulatoryRequestsViewList()
    {
        parent::__construct();
 	}

    public function preDisplay()
    {
        parent::preDisplay();
        $this->lv = new CustomRRQ_RegulatoryRequestsListViewSmarty(); // Ontrack 1937 Customization
        $this->handleDisplayExportCSVButton();
    }

    public function display()
    {
        parent::display();   
    }

    public function listViewProcess()
    {

        $this->processSearchForm();
        $this->lv->searchColumns = $this->searchForm->searchColumns;

        if (!$this->headers) {
            return;
        }

        $this->lv->ss->assign("SEARCH", true);
        $this->lv->ss->assign('savedSearchData', $this->searchForm->getSavedSearchData());

        // Ontrack 1937 Customization
        $this->lv->setup($this->seed, 'custom/modules/RRQ_RegulatoryRequests/includes/ListViewGeneric.tpl', $this->where, $this->params, 0, -1, $filterFields);
        $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
        echo $this->lv->display();
    }


    private function handleDisplayExportCSVButton()
    {
        global $mod_strings, $current_user, $log;

        $aclRolesBean = BeanFactory::getBean('ACLRoles')->retrieve_by_string_fields(
            [ 'name' => 'Regulatory'],
            false,
            true
        );

        if ($aclRolesBean) {
            // Query $current_user in the related beans of the Regulatory Role (ACLRoles bean) if exists
            $regulatoryUsers = $aclRolesBean->get_linked_beans(
                'users', 'Users', array(), 0, -1,0,
                "users.id = '{$current_user->id}' AND users.status='Active' "
            );

            /* if user is an admin OR has a 'Regulatory' Role: add the Generate Report in bulk actions menu */
            if ($current_user->is_admin || !empty($regulatoryUsers)) {
                $this->lv->actionsMenuExtraItems[] = "
                    <a  href='javascript:void(0)'
                        onclick=\"
                            return sListView.send_form(true, 'RRQ_RegulatoryRequests', 'index.php?entryPoint=RegulatoryRequestReport','Please select at least 1 record to proceed.')
                        \">{$mod_strings['LBL_EXPORT_XLS']}
                    </a>
                ";
            }

        }

    }
}


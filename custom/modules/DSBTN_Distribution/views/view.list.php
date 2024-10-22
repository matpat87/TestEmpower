<?php

require_once 'include/MVC/View/views/view.list.php';

if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class DSBTN_DistributionViewList extends ViewList
{
    function preDisplay()
    {
        parent::preDisplay();
    }

    public function listViewProcess()
    {
        $this->processSearchForm();
        $this->lv->searchColumns = $this->searchForm->searchColumns;

        if (!$this->headers) {
            return;
        }
        
        if (empty($_REQUEST['search_form_only']) || $_REQUEST['search_form_only'] == false) {
            $this->lv->ss->assign("SEARCH", true);
            $this->lv->ss->assign('savedSearchData', $this->searchForm->getSavedSearchData());
            // add recurring_source field to filter to be able acl check to use it on row level
            $this->lv->mergeDisplayColumns = true;
            $filterFields = array('recurring_source' => 1);
            $this->lv->setup($this->seed, 'custom/modules/DSBTN_Distribution/ListView/ListViewGeneric.tpl', $this->where, $this->params, 0, -1, $filterFields);
            $savedSearchName = empty($_REQUEST['saved_search_select_name']) ? '' : (' - ' . $_REQUEST['saved_search_select_name']);
            echo $this->lv->display();
        }
    }

    function display()
    {
        parent::display();
    }
}
<?php
require_once('include/ListView/ListViewSmarty.php');
require_once('custom/modules/RRQ_RegulatoryRequests/helpers/RRQ_RegulatoryRequestsHelper.php');


class CustomRRQ_RegulatoryRequestsListViewSmarty extends ListViewSmarty
{
    public function __construct()
    {
        parent::__construct();
        $this->targetList = true;
    }

    /**
     *
     * @param File $file deprecated
     * @param array $data
     * @param string $htmlVar
     * @return void|bool
     */
    public function process($file, $data, $htmlVar)
    {
        global $log, $current_user;
        
        foreach ($data['data'] as $index => $dataArr) {
            
            // $regulatoryRequestBean = BeanFactory::getBean('RRQ_RegulatoryRequests', $dataArr['ID']);
            // Check if Current logged user is the Regulatory Manager or is an Admin
            $isRegulatoryManager  = RRQ_RegulatoryRequestsHelper::isRegulatoryManagerUser(null, $dataArr['DIVISION_C']);

            // Ontrack #1937: If a Reg Request has reached the Completed status we should only allow Edit of any field by an Admin or anyone in the Regulatory Manager Group
            if (isset($dataArr['STATUS_C']) && $dataArr['STATUS_C'] == '3 - Complete' && (!$current_user->is_admin) && (!$isRegulatoryManager)) {
                $dataArr['CUSTOM_CAN_EDIT'] = false;
            } else {
                $dataArr['CUSTOM_CAN_EDIT'] = true;
            }

            $data['data'][$index] = $dataArr;
        }
        parent::process($file, $data, $htmlVar);
    }

    

}

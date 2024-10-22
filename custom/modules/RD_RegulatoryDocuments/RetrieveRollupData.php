<?php
    /**
     * The following function names below are the relationship names between account and their corresponding modules
     * This is done so that we no longer have to create custom "Create" and "Select" subpanel buttons
     * Exception would be for the "Remove" button which we have to control access if the actual record is under the account or rolled up from child accounts (If under account - Show, else - Hide)
     * Refer to file: SugarWidgetSubPanelRollupRemoveButton.php for Show/Hide remove button behavior
     */

    // Called via get_subpanel_data - function:rd_regulatorydocuments_ci_customeritems_1 on _override_custom_rollup_data.php
    function rd_regulatorydocuments_ci_customeritems_1() {
        //Get the current bean
        $bean = $GLOBALS['app']->controller->bean;

        //Create the SQL array
        $return_array = array();
        $return_array['select']  = " SELECT ci_customeritems.id ";
        $return_array['from']    = " FROM ci_customeritems ";
        $return_array['where']   = " WHERE ci_customeritems.deleted = 0 
            AND EXISTS (
                # Query to retrieve Customer Product related to the Regulatory Documents
                SELECT 1
                FROM rd_regulatorydocuments_ci_customeritems_1_c AS rd_ci
                INNER JOIN rd_regulatorydocuments AS rd
                    ON rd.id = rd_ci.rd_regulat9277cuments_ida
                    AND rd_ci.deleted = 0
                WHERE rd_ci.rd_regulatorydocuments_ci_customeritems_1ci_customeritems_idb = ci_customeritems.id
                    AND rd.id = '{$bean->id}'
            ) OR EXISTS (
                # Query to retrieve Customer Products related to the Regulatory Requests under that is related to the Regulatory Document
                SELECT 1
                FROM rrq_regulatoryrequests_ci_customeritems_2_c AS rrq_ci
                INNER JOIN rrq_regulatoryrequests AS rrq
                    ON rrq.id = rrq_ci.rrq_regula7aeaequests_ida
                    AND rrq.deleted = 0
                INNER JOIN rrq_regulatoryrequests_rd_regulatorydocuments_1_c AS rrq_rd
                    ON rrq.id = rrq_rd.rrq_regula991fequests_ida
                    AND rrq_rd.deleted = 0
                INNER JOIN rd_regulatorydocuments AS rd
                    ON rd.id = rrq_rd.rrq_regulad2fecuments_idb
                    AND rd.deleted = 0
                WHERE rrq_ci.rrq_regulatoryrequests_ci_customeritems_2ci_customeritems_idb = ci_customeritems.id
                    AND rd.id = '{$bean->id}'
            )
        ";

        return $return_array;
    }
?>